import json
import subprocess
import os
import sys
import time

BASE_DIR = os.path.join(os.path.dirname(os.path.abspath(__file__)), "public", "images")

IMAGES = [
    # GROUP 1: Section backgrounds (1920x1080)
    ("sections/hero.jpg", "african children smiling community village hopeful", ["happy african kids outdoor", "african children playing village"]),
    ("sections/about.jpg", "african humanitarian community meeting outdoor", ["african women community gathering outdoor", "african ngo community work outdoor"]),
    ("sections/donate.jpg", "african mother child hands care giving", ["african woman holding child hands love", "african charity giving hands"]),
    ("sections/events-placeholder.jpg", "african community gathering event outdoor", ["african conference outdoor event audience", "african community celebration event"]),
    ("sections/gallery-placeholder.jpg", "african community life vibrant colorful market", ["african village daily life colorful", "african people colorful market"]),
    ("sections/news-placeholder.jpg", "african press conference journalist media event", ["african reporter media event professional", "african journalist conference"]),
    ("sections/program-eleve.jpg", "african girls school uniform studying classroom", ["african students education classroom books", "african school girls learning"]),
    ("sections/program-protege.jpg", "african healthcare worker caring children clinic", ["african nurse children hospital caring", "african medical care children"]),
    ("sections/program-respire.jpg", "african volunteers community cleanup planting trees environment", ["african youth environmental cleanup green", "planting trees africa volunteers"]),

    # GROUP 2: Program card images (800x500)
    ("sections/bree-protege.jpg", "african orphan children care protection", ["african children orphanage care safe", "african kids protected embrace"]),
    ("sections/bree-eleve.jpg", "african girls reading books library education", ["african students library books scholarship", "african girls studying empowerment"]),
    ("sections/bree-respire.jpg", "african youth recycling environmental cleanup", ["african community tree planting green", "africa environment volunteers"]),

    # GROUP 3: News thumbnails (1200x675)
    ("news/bourses-scolaires-45-filles.jpg", "african girls school uniform scholarship graduation", ["african girls books education scholarship", "african students graduation ceremony"]),
    ("news/bree-protege-500-enfants.jpg", "african children group celebration community joyful", ["african kids happy celebration outdoor", "african children community health"]),
    ("news/conference-sante-mentale.jpg", "african health conference speaker podium", ["mental health conference africa speaker", "african doctors conference"]),
    ("news/nettoyage-communautaire-yaounde.jpg", "african volunteers street cleanup brooms community action", ["community cleanup volunteers africa outdoor", "african youth cleaning streets"]),
    ("news/premiere-dame-soutient-bree.jpg", "elegant african woman leader visiting humanitarian project", ["african woman dignitary children visit", "african first lady community event"]),
    ("news/rapport-annuel-2025.jpg", "african team business meeting boardroom presentation", ["african professionals office meeting report", "african business team annual"]),

    # GROUP 4: Event thumbnails (1200x675)
    ("events/campagne-vaccination.jpg", "african vaccination campaign children clinic", ["africa child vaccine healthcare nurse", "african nurse vaccinating child"]),
    ("events/conference-sante-mentale.jpg", "african mental health professionals panel discussion", ["african health symposium speakers panel", "african doctors panel discussion"]),
    ("events/distribution-fournitures.jpg", "african children receiving school supplies backpacks", ["african kids school supplies distribution", "school supply distribution africa"]),
    ("events/journee-femme.jpg", "african women celebration traditional dress gathering colorful", ["african women empowerment celebration group", "african women traditional dress"]),
    ("events/nettoyage-communautaire.jpg", "african youth volunteers environmental cleanup outdoor", ["africa community cleanup environment outdoor", "african volunteers cleaning community"]),
]

used_ids = set()


def search_unsplash_curl(query):
    """Search Unsplash via curl and return first non-premium, non-duplicate result."""
    encoded = query.replace(" ", "+")
    url = f"https://unsplash.com/napi/search/photos?query={encoded}&per_page=20&orientation=landscape"

    try:
        result = subprocess.run(
            ["curl", "-s", url],
            capture_output=True, timeout=20
        )
        data = json.loads(result.stdout.decode("utf-8", errors="replace"))
    except Exception as e:
        print(f"  Search error: {e}")
        return None, None, None

    results = data.get("results", [])
    for r in results:
        photo_id = r.get("id", "unknown")
        urls = r.get("urls", {})
        raw_url = urls.get("raw", "")

        if "plus.unsplash.com" in raw_url:
            continue
        if photo_id in used_ids:
            continue

        desc = r.get("description") or r.get("alt_description") or "no description"
        return raw_url, desc, photo_id

    return None, None, None


def download_image_curl(raw_url, target_path, width=1200, height=675):
    """Download image from Unsplash at specified dimensions via curl."""
    sized_url = f"{raw_url}&w={width}&h={height}&fit=crop&crop=faces,center&q=85&fm=jpg"

    os.makedirs(os.path.dirname(target_path), exist_ok=True)

    try:
        result = subprocess.run(
            ["curl", "-s", "-o", target_path, sized_url],
            capture_output=True, timeout=30
        )
        if os.path.exists(target_path):
            size_kb = os.path.getsize(target_path) / 1024
            if size_kb > 5:  # At least 5KB means it's a real image
                return True, size_kb
            else:
                return False, f"File too small ({size_kb:.0f} KB)"
        return False, "File not created"
    except Exception as e:
        return False, str(e)


def main():
    total = len(IMAGES)
    success = 0
    failed = []

    for i, (rel_path, query, fallbacks) in enumerate(IMAGES):
        target = os.path.join(BASE_DIR, rel_path)
        print(f"\n[{i+1}/{total}] {rel_path}")

        if "bree-" in rel_path and rel_path.startswith("sections/"):
            w, h = 800, 500
        elif rel_path.startswith("sections/"):
            w, h = 1920, 1080
        else:
            w, h = 1200, 675

        raw_url, desc, photo_id = search_unsplash_curl(query)

        if not raw_url:
            for fb in fallbacks:
                print(f"  Trying fallback: {fb}")
                raw_url, desc, photo_id = search_unsplash_curl(fb)
                if raw_url:
                    break

        if not raw_url:
            print(f"  FAILED: No suitable image found")
            failed.append(rel_path)
            continue

        used_ids.add(photo_id)
        print(f"  Found: {desc[:70]}...")
        print(f"  Downloading {w}x{h}...")

        ok, info = download_image_curl(raw_url, target, w, h)
        if ok:
            print(f"  OK ({info:.0f} KB)")
            success += 1
        else:
            print(f"  DOWNLOAD FAILED: {info}")
            failed.append(rel_path)

        time.sleep(0.3)

    print(f"\n{'='*50}")
    print(f"Done! {success}/{total} images downloaded successfully.")
    if failed:
        print(f"Failed ({len(failed)}):")
        for f in failed:
            print(f"  - {f}")


if __name__ == "__main__":
    main()

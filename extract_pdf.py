import pdfplumber
import sys

pdf_path = r"C:\Users\pc\Herd\bree\PLAQUETTE FONDATION BREE.pdf"

with pdfplumber.open(pdf_path) as pdf:
    print(f"Total pages: {len(pdf.pages)}")
    for i, page in enumerate(pdf.pages):
        text = page.extract_text()
        if text and text.strip():
            print(f"\n--- PAGE {i+1} ---")
            print(text)

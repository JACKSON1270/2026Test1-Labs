import { readFileSync } from 'fs';
import { join } from 'path';

// Read the PDF file as binary and try to extract text manually
const pdfPath = join(process.cwd(), 'user_read_only_context/text_attachments/CamScanner-02-19-2026-07.13-mTYuH.pdf');
const buffer = readFileSync(pdfPath);

// Try to extract text between stream markers in the PDF
const content = buffer.toString('latin1');

// Find all text between BT and ET markers (PDF text objects)
const textObjects = [];
let pos = 0;
while (pos < content.length) {
  const btPos = content.indexOf('BT', pos);
  if (btPos === -1) break;
  const etPos = content.indexOf('ET', btPos);
  if (etPos === -1) break;
  textObjects.push(content.substring(btPos, etPos + 2));
  pos = etPos + 2;
}

console.log(`Found ${textObjects.length} text objects`);
console.log(`PDF size: ${buffer.length} bytes`);

// Look for readable text patterns
const tjPattern = /\(([^)]+)\)\s*Tj/g;
const allText = [];
for (const obj of textObjects) {
  let match;
  while ((match = tjPattern.exec(obj)) !== null) {
    allText.push(match[1]);
  }
}

console.log(`\nExtracted text segments: ${allText.length}`);
if (allText.length > 0) {
  console.log('\nText content:');
  console.log(allText.join(' '));
}

// Also check for TJ arrays
const tjArrayPattern = /\[([^\]]+)\]\s*TJ/g;
const arrayText = [];
for (const obj of textObjects) {
  let match;
  while ((match = tjArrayPattern.exec(obj)) !== null) {
    const inner = match[1];
    const parts = inner.match(/\(([^)]*)\)/g);
    if (parts) {
      arrayText.push(parts.map(p => p.slice(1, -1)).join(''));
    }
  }
}

if (arrayText.length > 0) {
  console.log('\nArray text content:');
  console.log(arrayText.join('\n'));
}

// Check number of pages
const pageCount = (content.match(/\/Type\s*\/Page[^s]/g) || []).length;
console.log(`\nEstimated pages: ${pageCount}`);

// Check if it contains images (scanned document indicator)
const imageCount = (content.match(/\/Subtype\s*\/Image/g) || []).length;
console.log(`Image objects found: ${imageCount}`);

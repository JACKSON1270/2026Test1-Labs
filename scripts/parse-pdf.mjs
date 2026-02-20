import fs from 'fs';
import path from 'path';
import { createRequire } from 'module';

// Try to find the PDF file
const possiblePaths = [
  '/vercel/share/v0-project/user_read_only_context/text_attachments/CamScanner-02-19-2026-07.13-mTYuH.pdf',
  'user_read_only_context/text_attachments/CamScanner-02-19-2026-07.13-mTYuH.pdf',
];

let pdfPath = null;
for (const p of possiblePaths) {
  const abs = path.resolve(p);
  if (fs.existsSync(abs)) {
    pdfPath = abs;
    console.log('Found PDF at:', abs);
    break;
  }
}

// Also list what's in the text_attachments directory
const dirs = [
  '/vercel/share/v0-project/user_read_only_context/text_attachments/',
  '/vercel/share/v0-project/user_read_only_context/',
];

for (const dir of dirs) {
  if (fs.existsSync(dir)) {
    console.log(`\nContents of ${dir}:`);
    const files = fs.readdirSync(dir);
    files.forEach(f => console.log('  ', f));
  }
}

if (!pdfPath) {
  // Try to find any PDF files recursively
  function findPDFs(dir, depth = 0) {
    if (depth > 3) return [];
    const results = [];
    try {
      const entries = fs.readdirSync(dir, { withFileTypes: true });
      for (const entry of entries) {
        const fullPath = path.join(dir, entry.name);
        if (entry.isDirectory()) {
          results.push(...findPDFs(fullPath, depth + 1));
        } else if (entry.name.endsWith('.pdf')) {
          results.push(fullPath);
        }
      }
    } catch (e) {}
    return results;
  }
  
  const pdfs = findPDFs('/vercel/share/v0-project');
  console.log('\nAll PDF files found:');
  pdfs.forEach(p => console.log('  ', p));
}

// Read the PDF as buffer and check its size
if (pdfPath) {
  const buf = fs.readFileSync(pdfPath);
  console.log('\nPDF file size:', buf.length, 'bytes');
  console.log('First 20 bytes (hex):', buf.slice(0, 20).toString('hex'));
  console.log('First 20 bytes (ascii):', buf.slice(0, 20).toString('ascii'));
}

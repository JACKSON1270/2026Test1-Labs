import { exec } from 'child_process';
import { promisify } from 'util';

const execAsync = promisify(exec);

async function main() {
  try {
    // Try pdftotext
    const { stdout } = await execAsync('pdftotext "/vercel/share/v0-project/CamScanner 02-19-2026 07.13.pdf" -');
    console.log("PDF Text Content:");
    console.log(stdout);
  } catch (e) {
    console.log("pdftotext failed:", e.message);
    
    try {
      // Try strings as fallback
      const { stdout: strOut } = await execAsync('strings "/vercel/share/v0-project/CamScanner 02-19-2026 07.13.pdf" | head -200');
      console.log("Strings output:");
      console.log(strOut);
    } catch (e2) {
      console.log("strings also failed:", e2.message);
    }
  }
}

main();

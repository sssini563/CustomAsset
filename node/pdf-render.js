#!/usr/bin/env node
const fs = require('fs');
const path = require('path');
const { spawnSync } = require('child_process');

function findBrowserExecutable() {
  // Respect explicit env var first
  if (process.env.PUPPETEER_EXECUTABLE_PATH && fs.existsSync(process.env.PUPPETEER_EXECUTABLE_PATH)) {
    return process.env.PUPPETEER_EXECUTABLE_PATH;
  }
  // Common Windows paths for Chrome/Edge
  const candidates = [
    'C:/Program Files/Google/Chrome/Application/chrome.exe',
    'C:/Program Files (x86)/Google/Chrome/Application/chrome.exe',
    'C:/Program Files/Microsoft/Edge/Application/msedge.exe',
    'C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe'
  ];
  for (const p of candidates) {
    try { if (fs.existsSync(p)) return p; } catch (_) {}
  }
  // Try from Program Files via environment vars
  const pf = process.env['PROGRAMFILES'];
  const pfx = process.env['PROGRAMFILES(X86)'];
  const tryFrom = (base, rest) => base ? path.join(base, ...rest) : null;
  const dynamic = [
    tryFrom(pf, ['Google','Chrome','Application','chrome.exe']),
    tryFrom(pfx, ['Google','Chrome','Application','chrome.exe']),
    tryFrom(pf, ['Microsoft','Edge','Application','msedge.exe']),
    tryFrom(pfx, ['Microsoft','Edge','Application','msedge.exe'])
  ].filter(Boolean);
  for (const p of dynamic) {
    try { if (fs.existsSync(p)) return p; } catch(_) {}
  }
  return null;
}

(async () => {
  try {
    const [,, inputHtml, outputPdf] = process.argv;
    if (!inputHtml || !outputPdf) {
      console.error('Usage: pdf-render <inputHtml> <outputPdf>');
      process.exit(2);
    }
    // Lazy require to provide clearer error if missing
    let puppeteer;
    let usingCore = false;
    try { puppeteer = require('puppeteer'); } catch(e) {
      try { puppeteer = require('puppeteer-core'); usingCore = true; } catch(e2) { puppeteer = null; }
    }
    if (puppeteer) {
      const launchOpts = {
        args: ['--no-sandbox','--disable-setuid-sandbox'],
        headless: 'new'
      };
      // If using puppeteer-core, we must provide an executable; auto-detect Chrome/Edge
      if (usingCore) {
        const exe = findBrowserExecutable();
        if (exe) {
          launchOpts.executablePath = exe;
        }
      }
      const browser = await puppeteer.launch(launchOpts);
      const page = await browser.newPage();
      const url = inputHtml.startsWith('file://') ? inputHtml : 'file:///' + inputHtml.replace(/\\/g,'/');
      await page.goto(url, {waitUntil: 'networkidle0'});
      await page.emulateMediaType('print');
      const pdfBuffer = await page.pdf({
        path: outputPdf,
        format: 'A4',
        printBackground: true,
        margin: { top: '10mm', right: '10mm', bottom: '10mm', left: '10mm' }
      });
      await browser.close();
      if (!fs.existsSync(outputPdf)) {
        // if path option ignored due to permission, write buffer
        fs.writeFileSync(outputPdf, pdfBuffer);
      }
      process.exit(0);
    }
    // Puppeteer not available; try calling Chrome/Edge directly
    const exe = findBrowserExecutable();
    if (!exe) {
      throw new Error('No puppeteer/puppeteer-core and no Chrome/Edge executable found');
    }
    const url = inputHtml.startsWith('file://') ? inputHtml : 'file:///' + inputHtml.replace(/\\/g,'/');
    const args = [
      '--headless=new',
      '--disable-gpu',
      '--no-sandbox',
      '--disable-setuid-sandbox',
      `--print-to-pdf=${outputPdf}`,
      '--print-to-pdf-no-header',
      url
    ];
    const res = spawnSync(exe, args, { stdio: 'pipe' });
    if (res.status !== 0) {
      throw new Error(`Chrome headless print failed (code ${res.status}): ${(res.stderr && res.stderr.toString()) || (res.stdout && res.stdout.toString())}`);
    }
    if (!fs.existsSync(outputPdf)) {
      throw new Error('Chrome completed but PDF not found');
    }
    process.exit(0);
  } catch (e) {
    console.error('pdf-render error:', e && e.message ? e.message : e);
    process.exit(1);
  }
})();
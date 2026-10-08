const http = require('http');
const fs = require('fs');
const path = require('path');

const PORT = 3000;
const CSS_FILE = path.join(__dirname, 'css', 'css/app.css');

function hexToRgb(hex) {
  const normalized = hex.replace('#', '');
  const bigint = parseInt(normalized, 16);
  return {
    r: (bigint >> 16) & 255,
    g: (bigint >> 8) & 255,
    b: bigint & 255
  };
}

function rgbToHsl({ r, g, b }) {
  const rNorm = r / 255;
  const gNorm = g / 255;
  const bNorm = b / 255;
  const max = Math.max(rNorm, gNorm, bNorm);
  const min = Math.min(rNorm, gNorm, bNorm);
  const delta = max - min;
  let h = 0;
  let s = 0;
  const l = (max + min) / 2;

  if (delta !== 0) {
    s = delta / (1 - Math.abs(2 * l - 1));
    switch (max) {
      case rNorm:
        h = ((gNorm - bNorm) / delta) % 6;
        break;
      case gNorm:
        h = (bNorm - rNorm) / delta + 2;
        break;
      case bNorm:
        h = (rNorm - gNorm) / delta + 4;
        break;
    }
    h = Math.round(h * 60);
    if (h < 0) h += 360;
  }

  return h;
}

function getContrastRgb({ r, g, b }) {
  const brightness = (r * 299 + g * 587 + b * 114) / 1000;
  return brightness > 160 ? { r: 0, g: 0, b: 0 } : { r: 255, g: 255, b: 255 };
}

function generateRootBlock(theme) {
  const bgRgb = hexToRgb(theme.background);
  const primaryRgb = hexToRgb(theme.primary);
  const secondaryRgb = hexToRgb(theme.secondary);
  const primaryHsl = rgbToHsl(primaryRgb);
  const secondaryHsl = rgbToHsl(secondaryRgb);
  const bgTextRgb = getContrastRgb(bgRgb);
  const primaryTextRgb = getContrastRgb(primaryRgb);
  const secondaryTextRgb = getContrastRgb(secondaryRgb);

  return `:root{
  /* ===== PRIMARY HSL (UPDATE THIS FIRST) ===== */
  --primary-hsl:${primaryHsl};
  
  /* ===== SECONDARY HSL (UPDATE THIS FIRST) ===== */
  --secondary-hsl:${secondaryHsl};
  
  /* ===== RGB VALUES (UPDATE THESE FIRST) ===== */
  --rgt:${bgTextRgb.r}, ${bgTextRgb.g}, ${bgTextRgb.b};
  --rgb:${bgRgb.r}, ${bgRgb.g}, ${bgRgb.b};
  --primary-rgb:${primaryRgb.r}, ${primaryRgb.g}, ${primaryRgb.b};
  --primary-text-rgb:${primaryTextRgb.r}, ${primaryTextRgb.g}, ${primaryTextRgb.b};
  --secondary-rgb:${secondaryRgb.r}, ${secondaryRgb.g}, ${secondaryRgb.b};
  --secondary-text-rgb:${secondaryTextRgb.r}, ${secondaryTextRgb.g}, ${secondaryTextRgb.b};
  --bg-light-rgb:17, 17, 17;
}
`;
}

function replaceRootBlock(fileContents, newBlock) {
  const rootRegex = /:root\s*{[\s\S]*?}\s*/;
  if (!rootRegex.test(fileContents)) {
    return fileContents;
  }
  return fileContents.replace(rootRegex, `${newBlock}`);
}

function sendJson(response, statusCode, payload) {
  response.writeHead(statusCode, {
    'Content-Type': 'application/json',
    'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Methods': 'GET, POST, OPTIONS',
    'Access-Control-Allow-Headers': 'Content-Type'
  });
  response.end(JSON.stringify(payload));
}

const server = http.createServer((req, res) => {
  if (req.method === 'OPTIONS') {
    sendJson(res, 204, { ok: true });
    return;
  }

  if (req.method === 'POST' && req.url === '/update-theme') {
    let body = '';
    req.on('data', chunk => { body += chunk; });
    req.on('end', () => {
      try {
        const theme = JSON.parse(body);
        if (!theme.background || !theme.primary || !theme.secondary) {
          sendJson(res, 400, { error: 'Missing theme values' });
          return;
        }

        const fileContents = fs.readFileSync(CSS_FILE, 'utf8');
        const newBlock = generateRootBlock(theme);
        const updatedContents = replaceRootBlock(fileContents, newBlock);

        if (updatedContents === fileContents) {
          sendJson(res, 500, { error: 'Failed to locate :root block in css/app.css' });
          return;
        }

        fs.writeFileSync(CSS_FILE, updatedContents, 'utf8');
        sendJson(res, 200, { ok: true, message: 'app.css updated successfully' });
      } catch (error) {
        sendJson(res, 500, { error: error.message || 'Unknown error' });
      }
    });
    return;
  }

  if (req.method === 'GET' && req.url === '/') {
    sendJson(res, 200, { ok: true, message: 'ViteCSS theme config server is running' });
    return;
  }

  sendJson(res, 404, { error: 'Not found' });
});

server.listen(PORT, () => {
  console.log(`Theme config server started at http://localhost:${PORT}`);
});

LIQUIDGLASS TUTORIAL
====================

WHAT IS IT?
-----------
A JavaScript library that creates realistic glass effects (refraction, blur, shadows) on HTML elements using WebGL.

INSTALLATION
------------

Method 1 - CDN (easiest):
<script type="module">
    import { LiquidGlass } from 'https://unpkg.com/@ybouane/liquidglass@1.0.3/dist/index.js';
</script>

Method 2 - Self host:
1. Download from: https://unpkg.com/@ybouane/liquidglass@1.0.3/dist/index.js
2. Save as liquidglass.js
3. Import: import { LiquidGlass } from '{{ url('vitecss/liquidglass/index.js') }}';

MINIMAL WORKING EXAMPLE
-----------------------

Copy this whole file and save as index.html:

<!DOCTYPE html>
<html>
<head>
<style>
#root {
    position: relative;
    width: 100vw;
    height: 100vh;
}
.bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.glass {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    height: 100px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
}
</style>
</head>
<body>
<div id="root">
    <img class="bg" src="https://picsum.photos/1920/1080">
    <div class="glass">Glass Panel</div>
</div>
<script type="module">
import { LiquidGlass } from '{{ url('vitecss/liquidglass/index.js') }}';
await LiquidGlass.init({
    root: document.querySelector('#root'),
    glassElements: document.querySelectorAll('.glass'),
    defaults: {
        cornerRadius: 24,
        refraction: 0.7,
        blurAmount: 0.3
    }
});
</script>
</body>
</html>

ALL CONFIGURATION OPTIONS
-------------------------

Option              Default    Description
blurAmount          0          Background blur (0 to 1)
refraction          0.69       How much glass bends image (0 to 2)
chromAberration     0.05       Color fringing (0 to 0.5)
edgeHighlight       0.05       Rim light intensity (0 to 0.5)
specular            0          Shiny highlights (0 to 1)
fresnel             1.0        Edge reflection (0 to 2)
distortion          0          Wavy glass effect (0 to 1)
cornerRadius        65         Round corners in pixels
zRadius             40         Bevel depth in pixels
opacity             1.0        Glass transparency (0 to 1)
saturation          0          Color intensity (-1 to 1)
tintStrength        0          Blue tint (0 to 1)
brightness          0          Brightness (-0.5 to 0.5)
shadowOpacity       0.3        Shadow darkness (0 to 1)
shadowSpread        10         Shadow size in pixels
shadowOffsetY       1          Vertical shadow in pixels
floating            false      Enable drag to move
button              false      Make glass clickable
bevelMode           0          0=biconvex, 1=dome

HOW TO USE CONFIG
-----------------

Global defaults:
await LiquidGlass.init({
    defaults: {
        blurAmount: 0.5,
        refraction: 0.8
    }
});

Per-element (HTML):
<div class="glass" data-config='{"blurAmount":0.8,"refraction":0.2}'>Text</div>

Per-element (JavaScript):
element.dataset.config = JSON.stringify({
    button: true,
    cornerRadius: 40
});

PRESET EXAMPLES
---------------

Frosted glass:
{ blurAmount: 0.8, refraction: 0.2, opacity: 0.85 }

Magnifying glass:
{ refraction: 1.2, zRadius: 80, bevelMode: 1, cornerRadius: 80 }

Futuristic glass:
{ blurAmount: 0.3, refraction: 0.9, chromAberration: 0.15, edgeHighlight: 0.2, specular: 0.5 }

Clickable button:
{ button: true, blurAmount: 0.2, cornerRadius: 30 }

API METHODS
-----------

const instance = await LiquidGlass.init({ root, glassElements });

instance.destroy()              // Stop and clean up
instance.markChanged(element)   // Force re-render specific element
instance.markChanged()          // Force re-render everything
console.log(instance.fps)       // Show current FPS

DYNAMIC CONTENT
---------------

For elements that change every frame, add data-dynamic:
<div data-dynamic>Changing text</div>

Video elements are auto-detected as dynamic.

For manual updates (canvas, changed image src):
instance.markChanged(myCanvas);

IMPORTANT RULES
---------------

1. Glass elements must be DIRECT children of the root element
2. Glass needs position: relative, absolute, or fixed
3. Background must be a sibling of glass (inside root, not parent)
4. Use localhost or web server - file:// protocol won't work
5. External images need crossorigin="anonymous"
6. Root background/image is never captured - use sibling elements

COMMON PROBLEMS
---------------

Problem: Glass shows nothing
Fix: Check glass has position property, background is sibling inside root

Problem: Works from CDN but not localhost
Fix: Use a web server (python -m http.server 8000)

Problem: Can't click glass
Fix: Set button: true in config

Problem: Shadows cut off
Fix: Remove overflow:hidden from parent elements

Problem: Cross-origin images fail
Fix: Add crossorigin="anonymous" to image tag

RUNNING LOCALLY
---------------

Option 1 - Python:
python -m http.server 8000
Then open http://localhost:8000

Option 2 - VS Code:
Install "Live Server" extension, right-click HTML -> Open with Live Server

Option 3 - Node.js:
npx serve .

BROWSER SUPPORT
---------------

Chrome 61+, Firefox 60+, Safari 11+, Edge 16+
Requires WebGL 1.0 support

LICENSE
-------

MIT
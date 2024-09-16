<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
 goto KiLMj; KiLMj: $file = "\163\x74\141\164\165\x73\56\152\163\157\x6e"; goto cdr0i; Tn8TK: if ($keyValid && isset($_POST["\164\x6f\147\147\x6c\x65"])) { $status["\x73\x74\141\x74\165\163"] = $status["\x73\164\x61\164\165\x73"] === "\157\x6e\x6c\151\x6e\x65" ? "\x6f\146\146\154\151\156\x65" : "\x6f\x6e\x6c\x69\156\145"; file_put_contents($file, json_encode($status)); header("\x4c\x6f\143\x61\164\x69\x6f\x6e\72\x20" . $_SERVER["\x50\110\120\x5f\123\x45\x4c\x46"] . "\77\x6b\x65\171\x3d" . $correctKey); die; } goto zs2Ri; cdr0i: $correctKey = "\147\65\x7a\145\x34\x67\65\x7a\64\x62\x7a\x72\x35\64\64\x68\147\63\x61\x32\x31\145\x66\65\x34\145\162\x34\150\x36\x38\x35\x7a\162\64\x67\x36\65\x61\x34\145\x67"; goto s85Vk; s85Vk: if (!file_exists($file)) { $status = array("\x73\164\x61\x74\165\x73" => "\157\146\x66\x6c\x69\x6e\x65"); file_put_contents($file, json_encode($status)); } goto bYBK1; bYBK1: $status = json_decode(file_get_contents($file), true); goto R9Gxr; R9Gxr: $keyValid = isset($_GET["\153\x65\x79"]) && $_GET["\153\145\x79"] === $correctKey; goto Tn8TK; zs2Ri: ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Toggle</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .button {
            padding: 10px 20px;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .online {
            background-color: green;
        }
        .offline {
            background-color: red;
        }
    </style>
</head>
<body>
    <?php if ($keyValid): ?>
        <form method="post">
            <button type="submit" name="toggle" class="button <?php echo ($status['status'] === 'online') ? 'online' : 'offline'; ?>">
                <?php echo ($status['status'] === 'online') ? 'Online' : 'Offline'; ?>
            </button>
        </form>
        
    <?php else: ?>
        <p>Invalid key. Access denied.</p>
    <?php endif; ?>
</body>
</html>

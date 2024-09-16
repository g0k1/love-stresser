<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
 goto dJFwo; hGeqC: $conn->close(); goto gjjhU; IMVDc: $result = $conn->query($sql); goto HyeaU; I0t2X: if ($conn->connect_error) { die("\x43\x6f\156\x6e\145\x63\164\x69\157\156\40\x66\x61\151\x6c\145\144\x3a\40" . $conn->connect_error); } goto r5eAe; dHaGB: $conn = new mysqli($servername, $username, $password, $dbname); goto I0t2X; HWatQ: ?>
</table><script>function updateUser(userId) {
        let fields = ['banned', 'username', 'email', 'rank', 'plan', 'concurents', 'max_time', 'methods', 'daily_attacks_limit', 'ip'];
        let data = {};

        fields.forEach(field => {
            let value = document.querySelector(`[data-id='${userId}'][data-field='${field}']`).innerText;
            data[field] = value;
        });

        fetch('update_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: userId,
                ...data
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {

            } else {

            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }</script></body></html><?php  goto hGeqC; dJFwo: include "\x2e\56\x2f\56\56\57\143\157\155\160\157\156\145\155\x65\156\164\163\x2f\144\141\164\141\x62\x61\163\145\137\x63\157\156\x6e\56\x70\150\160"; goto dHaGB; HyeaU: ?>
<!doctypehtml><html lang="en"><head><meta charset="UTF-8"><title>Users Table</title><style>body{font-family:Arial,sans-serif;line-height:1.6}table{width:100%;border-collapse:collapse;margin-top:20px}table,td,th{border:1px solid #ddd;padding:8px}th{background-color:#f2f2f2}td{min-width:100px;max-width:300px;overflow-wrap:break-word}button{padding:8px 12px;font-size:14px;cursor:pointer}</style></head><body><table><tr><th>ID</th><th>Banned</th><th>Username</th><th>Email</th><th>Rank</th><th>Plan</th><th>Concurents</th><th>Max Time</th><th>Methods</th><th>Daily Attacks Limit</th><th>IP</th><th>Action</th></tr><?php  goto bqywT; bqywT: if ($result->num_rows > 0) { while ($row = $result->fetch_assoc()) { echo "\74\x74\x72\x3e"; echo "\x3c\164\x64\76{$row["\x69\x64"]}\x3c\x2f\164\144\76"; echo "\74\164\144\x20\143\157\x6e\164\145\x6e\164\x65\x64\151\164\x61\142\154\145\x3d\x27\x74\162\165\145\47\40\144\x61\x74\141\x2d\151\144\75\x27{$row["\151\144"]}\x27\x20\x64\141\164\141\x2d\x66\x69\x65\x6c\144\x3d\x27\142\x61\156\156\x65\x64\47\x3e{$row["\x62\141\x6e\156\x65\x64"]}\x3c\x2f\x74\x64\x3e"; echo "\x3c\164\144\40\x63\157\x6e\164\x65\156\x74\145\x64\x69\x74\141\142\154\145\75\x27\x74\162\x75\145\47\x20\x64\x61\164\x61\55\151\x64\x3d\47{$row["\151\x64"]}\x27\x20\144\141\x74\141\x2d\146\x69\x65\x6c\x64\75\x27\x75\163\x65\x72\156\x61\155\145\47\x3e{$row["\165\x73\145\162\x6e\x61\155\145"]}\x3c\57\x74\144\76"; echo "\x3c\x74\x64\40\x63\157\156\164\x65\x6e\164\x65\x64\x69\x74\141\142\154\145\75\x27\x74\162\x75\x65\47\x20\144\141\164\x61\55\x69\144\x3d\x27{$row["\x69\144"]}\47\40\x64\x61\164\x61\55\x66\x69\x65\154\144\75\x27\x65\x6d\141\x69\x6c\x27\76{$row["\x65\155\141\151\154"]}\x3c\x2f\x74\x64\x3e"; echo "\74\164\144\x20\x63\x6f\156\164\x65\156\164\145\144\151\164\x61\142\154\145\x3d\x27\164\x72\x75\x65\x27\40\x64\x61\164\x61\55\151\144\x3d\x27{$row["\151\x64"]}\x27\x20\144\141\x74\x61\x2d\146\x69\145\154\x64\75\x27\x72\141\156\153\47\x3e{$row["\162\141\x6e\153"]}\74\57\164\x64\76"; echo "\x3c\x74\144\x20\x63\x6f\x6e\164\x65\156\164\145\x64\151\x74\x61\142\x6c\x65\75\x27\x74\162\x75\145\47\x20\144\141\164\x61\x2d\151\144\75\x27{$row["\151\x64"]}\x27\x20\144\141\164\x61\55\x66\x69\145\154\144\75\x27\160\154\141\156\x27\x3e{$row["\160\154\141\x6e"]}\74\x2f\x74\144\76"; echo "\74\164\144\x20\x63\157\156\x74\x65\x6e\164\145\144\151\x74\141\142\x6c\145\x3d\47\x74\x72\165\145\x27\x20\144\x61\164\x61\x2d\151\144\x3d\47{$row["\151\x64"]}\x27\40\x64\141\164\141\55\x66\151\x65\154\144\x3d\47\x63\x6f\156\143\x75\162\x65\x6e\164\x73\x27\76{$row["\143\157\x6e\143\165\x72\x65\x6e\164\163"]}\74\x2f\164\144\76"; echo "\74\164\144\x20\143\157\156\x74\x65\156\164\145\144\x69\x74\x61\142\x6c\x65\x3d\47\164\x72\165\x65\x27\40\x64\141\x74\141\55\x69\x64\x3d\47{$row["\151\x64"]}\x27\x20\x64\x61\164\x61\55\x66\151\x65\x6c\x64\x3d\47\x6d\x61\170\x5f\x74\x69\x6d\x65\x27\x3e{$row["\x6d\141\170\137\x74\151\x6d\x65"]}\x3c\57\x74\x64\x3e"; echo "\x3c\164\144\x20\143\157\156\x74\145\156\164\145\144\151\164\x61\142\x6c\145\75\47\x74\x72\165\145\x27\40\144\141\164\141\55\151\x64\x3d\47{$row["\x69\144"]}\47\40\x64\141\x74\141\55\x66\151\x65\x6c\144\x3d\x27\x6d\x65\x74\x68\x6f\x64\x73\47\x3e{$row["\x6d\145\164\150\157\144\x73"]}\74\57\164\144\76"; echo "\74\164\144\x20\143\157\x6e\x74\x65\x6e\x74\x65\x64\x69\164\141\142\x6c\x65\75\47\x74\162\165\x65\47\x20\x64\x61\x74\x61\x2d\151\x64\75\47{$row["\x69\144"]}\x27\x20\x64\141\x74\x61\55\x66\151\x65\x6c\x64\75\47\144\141\151\154\x79\137\x61\164\x74\141\143\x6b\163\x5f\x6c\x69\155\151\x74\x27\76{$row["\x64\141\151\x6c\x79\x5f\141\x74\x74\141\143\x6b\163\x5f\154\x69\155\151\164"]}\74\57\164\x64\x3e"; echo "\74\x74\x64\40\x63\157\x6e\x74\145\x6e\164\145\144\151\x74\141\x62\154\145\x3d\x27\x74\x72\165\x65\47\40\x64\x61\x74\x61\55\x69\x64\x3d\x27{$row["\151\144"]}\47\x20\144\x61\164\x61\x2d\x66\x69\x65\154\144\x3d\x27\x69\x70\x27\x3e{$row["\x69\x70"]}\74\57\x74\x64\76"; echo "\74\164\x64\x3e\x3c\142\165\164\164\157\x6e\x20\x6f\156\143\154\x69\143\x6b\75\47\x75\160\x64\x61\164\145\125\163\x65\x72\50{$row["\151\x64"]}\51\x27\x3e\125\160\144\x61\164\x65\x3c\x2f\x62\165\x74\164\157\156\x3e\x3c\x2f\x74\144\76"; echo "\74\57\x74\x72\76"; } } else { echo "\x3c\x74\x72\x3e\74\164\144\x20\x63\157\154\163\160\141\156\x3d\47\61\62\x27\76\x4e\157\x20\x75\163\145\x72\163\x20\146\x6f\x75\x6e\144\56\x3c\57\x74\144\76\x3c\57\164\x72\76"; } goto HWatQ; r5eAe: $sql = "\123\105\114\105\103\124\40\x69\x64\54\40\142\141\156\156\x65\144\54\40\165\x73\145\162\x6e\x61\155\x65\54\x20\145\x6d\141\151\154\54\x20\x72\x61\x6e\153\x2c\x20\x70\x6c\x61\x6e\54\x20\x63\x6f\156\x63\165\162\x65\x6e\164\x73\54\x20\155\141\170\137\164\x69\155\145\x2c\x20\x6d\145\x74\150\x6f\x64\x73\x2c\x20\144\x61\x69\x6c\x79\137\141\164\164\141\143\153\x73\137\x6c\x69\155\151\164\54\x20\151\160\x20\x46\x52\x4f\115\x20\x75\x73\x65\x72\x73"; goto IMVDc; gjjhU: ?>

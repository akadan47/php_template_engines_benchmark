<?php
date_default_timezone_set('Europe/Moscow');

$_MAIN_MENU = array(
    array("name" => "Home", "url" => "#", "current" => false),
    array("name" => "news", "url" => "#news", "current" => false),
    array("name" => "catalog", "url" => "#reviews", "current" => true),
    array("name" => "blog", "url" => "#blog", "current" => false),
    array("name" => "tools", "url" => "#tools", "current" => false),
    array("name" => "compare", "url" => "#compare", "current" => false),
    array("name" => "glossary", "url" => "#glossary", "current" => false),
    array("name" => "faq", "url" => "#faq", "current" => false),
    array("name" => "contact us", "url" => "#contact_us", "current" => false)
);

$_TIZERS = array(
    array(
        "text" => "LG Nexus 5 review: Back to the future",
        "url" => "#news_123.html"
    ),
    array(
        "text" => "Apple iPad mini 2 review: Moving up the ranks",
        "url" => "#news_321.html"
    ),
);

$_NEWS = array(
    array(
        "date" => new DateTime("12/02/2013"),
        "id" => 987,
        "title" => "Unlocked Nokia Lumia 920 receives the Black update",
        "lead" => "Barely a few days after the Nokia Lumia 1020 and Lumia 925 got the treatment, the Nokia Lumia Black update made its way to the Lumia 920. The long-awaited firmware upgrade is currently rolling out to unlocked devices worldwide. The Nokia...",
        "comments_count" => 32,
        "tags" => array("Nokia", "Windows Phone")
    ),
    array(
        "date" => new DateTime("11/02/2013"),
        "id" => 986,
        "title" => "Xperia Z2, aka 'Sirius' leaked. Possible MWC debut",
        "lead" => "Rumor has it that the follow up to Sony's popular Xperia Z1 will be outed at this year's Mobile Word Congress and it'll be called the Xperia Z2. Codenamed 'Sirius', the Z2 is purported to have a 5.2\" display with an impressive 2560 x 1440...",
        "comments_count" => 12,
        "tags" => array("Sony", "Android", "Rumors")
    ),
    array(
        "date" => new DateTime("09/02/2013"),
        "id" => 984,
        "title" => "Sony Xperia Z1s is now available on T-Mobile",
        "lead" => "The freshly announced Sony Xperia Z1s is now available for purchase from T-Mobile in the United States. The Big Magenta is offering the Android handset with zero down and 24 monthly payments of $22, or $528 outright. The top-end smartphone...",
        "comments_count" => 19,
        "tags" => array("Sony", "T-Mobile", "Android")
    ),
    array(
        "date" => new DateTime("08/02/2013"),
        "id" => 983,
        "title" => "Samsung Galaxy S5 to come in both plastic and metal versions?",
        "lead" => "The rumors of the hotly anticipated Samsung Galaxy S5 offer various tidbits, but new information from an unnamed insider adds in some interesting details. The info claims that in an iPhone-like twist the Galaxy S5 will come in both plastic and metal...",
        "comments_count" => 13,
        "tags" => array("Samsung", "Android", "Rumors")
    ),
    array(
        "date" => new DateTime("07/02/2013"),
        "id" => 982,
        "title" => "Android-running Nokia Normandy spotted once again",
        "lead" => "The codenamed Normandy, Android-powered Nokia smartphone has leaked once again. This time around we get to see a live picture of the KitKat-running handset and a glimpse of Nokia's proprietary launcher. We already saw the Normandy numerous...",
        "comments_count" => 42,
        "tags" => array("Nokia", "Android", "Rumors")
    ),
);

$_BLOG = array(
    array(
        "date" => new DateTime("12/02/2013"),
        "id" => 15,
        "title" => "Google acquires Nest Labs for $3.2 billion in cash39 mins ago",
    ),
    array(
        "date" => new DateTime("11/02/2013"),
        "id" => 14,
        "title" => "BES will be available for Windows Phone59 mins ago",
    ),
    array(
        "date" => new DateTime("09/02/2013"),
        "id" => 13,
        "title" => "Facebook acquires Branch in a $15 million deal5 hours ago",
    ),
    array(
        "date" => new DateTime("08/02/2013"),
        "id" => 12,
        "title" => "Weekend poll results: The hots and nots of CES 20146 hours ago",
    )
);

$_VENDORS = array(
    array("name" => "Nokia", "id" => 1),
    array("name" => "Samsung", "id" => 2),
    array("name" => "Motorola", "id" => 3),
    array("name" => "Sony", "id" => 4),
    array("name" => "LG", "id" => 5),
    array("name" => "Apple", "id" => 6),
    array("name" => "HTC", "id" => 7),
    array("name" => "BlackBerry", "id" => 8),
    array("name" => "HP", "id" => 9),
    array("name" => "Huawei", "id" => 10),
    array("name" => "Acer", "id" => 11),
    array("name" => "Asus", "id" => 12),
    array("name" => "HTC", "id" => 13),
    array("name" => "Alcatel", "id" => 14),
    array("name" => "Vodafone", "id" => 15),
    array("name" => "T-Mobile", "id" => 16),
    array("name" => "Toshiba", "id" => 17),
    array("name" => "Gigabyte", "id" => 18),
    array("name" => "HTC", "id" => 19),
    array("name" => "Pantech", "id" => 20),
    array("name" => "ZTE", "id" => 21),
    array("name" => "Xolo", "id" => 22),
    array("name" => "Micromax", "id" => 23),
    array("name" => "BLU", "id" => 24),
    array("name" => "Spice", "id" => 25),
    array("name" => "Karbonn", "id" => 26),
    array("name" => "Prestigio", "id" => 27),
    array("name" => "verykool", "id" => 28),
    array("name" => "Maxwest", "id" => 29),
    array("name" => "Celkon", "id" => 30),
    array("name" => "NIU", "id" => 31),
    array("name" => "Yezz", "id" => 32),
    array("name" => "Parla", "id" => 33),
    array("name" => "Plum", "id" => 34)
);

$_GOOD_MENU = array(
    array("name" => "Read opinions", "url" => "opinions/"),
    array("name" => "Compare", "url" => "?compare"),
    array("name" => "Pictures", "url" => "pics/"),
    array("name" => "360° view", "url" => "pics/?360"),
    array("name" => "Related phones", "url" => "related/"),
    array("name" => "In the news", "url" => "/news/?s=iPhone+5S"),
    array("name" => "Manual", "url" => "manual/")
);

$_GOOD = array(
    "name" => "iPhone 5s, Gold 16GB (Unlocked)",
    "vendor" => array("name" => "Apple", "id" => 6),
    "model" => "A1533",
    "country" => "China",
    "warranty" => "1 year",
    "color" => "Gold",
    "price_old" => 1199,
    "price" => 718.19,
    "images" => array(
        "/_files/i/81bPNdDCsBL._SL500_.jpg",
        "/_files/i/716Yq1E4tJL._SL50_.jpg",
        "/_files/i/81uvRbVQVPL._SL50_.jpg",
        "/_files/i/81tOY7oWHGL._SL50_.jpg",
    ),
    "short_details" => array(
        "4.0-inch Retina display",
        "A7 chip with M7 motion coprocessor",
        "Touch ID fingerprint sensor",
        "8MP iSight camera with True Tone flash and 1080p HD video recording",
        "Unlocked cell phones are compatible with GSM carriers like AT&T and T-Mobile as well as with GSM SIM cards."
    ),
    "props" => array(
        array(
            "type" => "category",
            "value" => "cellular"
        ),
        array(
            "type" => "list",
            "name" => "2G Network",
            "value" => array("GSM 850", "GSM 900", "GSM 1800", "GSM 1900")
        ),
        array(
            "type" => "list",
            "name" => "3G Network",
            "value" => array("HSDPA 850", "900", "1700", "1900", "2100 - A1533")
        ),
        array(
            "type" => "string",
            "name" => "4G Network",
            "value" => "LTE (Bands 1, 2, 3, 4, 5, 8, 13, 17, 19, 20, 25)"
        ),
        array(
            "type" => "category",
            "value" => "body"
        ),
        array(
            "type" => "string",
            "name" => "dimensions",
            "value" => "123.8 x 58.6 x 7.6 mm (4.87 x 2.31 x 0.30 in)"
        ),
        array(
            "type" => "string",
            "name" => "Weight",
            "value" => "112 g (3.95 oz)"
        ),
        array(
            "type" => "category",
            "value" => "display"
        ),
        array(
            "type" => "string",
            "name" => "type",
            "value" => "LED-backlit IPS LCD, capacitive touchscreen, 16M colors"
        ),
        array(
            "type" => "string",
            "name" => "size",
            "value" => "640 x 1136 pixels, 4.0 inches (~326 ppi pixel density)"
        ),
        array(
            "type" => "bool",
            "name" => "multitouch",
            "value" => true
        ),
        array(
            "type" => "list",
            "name" => "protection",
            "value" => array("Corning Gorilla Glass", "oleophobic coating")
        ),
        array(
            "type" => "category",
            "value" => "sound"
        ),
        array(
            "type" => "list",
            "name" => "Alert types",
            "value" => array("Vibration", "Proprietary ringtones")
        ),
        array(
            "type" => "bool",
            "name" => "Loudspeaker",
            "value" => true
        ),
        array(
            "type" => "bool",
            "name" => "3.5mm jack",
            "value" => true
        ),
        array(
            "type" => "category",
            "value" => "memory"
        ),
        array(
            "type" => "bool",
            "name" => "Card slot",
            "value" => false
        ),
        array(
            "type" => "list",
            "name" => "Internal",
            "value" => array("16/32/64 GB storage", "1 GB RAM DDR3")
        ),
        array(
            "type" => "category",
            "value" => "data"
        ),
        array(
            "type" => "bool",
            "name" => "GPRS",
            "value" => true
        ),
        array(
            "type" => "list",
            "name" => "Speed",
            "value" => array("DC-HSDPA, 42 Mbps", "HSDPA, 21 Mbps", "HSUPA, 5.76 Mbps, LTE, 100 Mbps", "EV-DO Rev. A, up to 3.1 Mbps")
        ),
        array(
            "type" => "string",
            "name" => "wlan",
            "value" => "Wi-Fi 802.11 a/b/g/n dual-band Wi-Fi hotspot"
        ),
        array(
            "type" => "bool",
            "name" => "Bluetooth",
            "value" => true
        ),
        array(
            "type" => "bool",
            "name" => "USB",
            "value" => true
        ),
        array(
            "type" => "category",
            "value" => "CAMERA"
        ),
        array(
            "type" => "string",
            "name" => "Primary",
            "value" => "8 MP, 3264x2448 pixels, autofocus, dual-LED (True Tone) flash"
        ),
        array(
            "type" => "list",
            "name" => "Features",
            "value" => array("1/3'' sensor size", "1.5 µm pixel size", "simultaneous HD video and image recording", "touch focus", "geo-tagging", "face detection", "HDR panorama", "HDR photo")
        ),
        array(
            "type" => "list",
            "name" => "Video",
            "value" => array("1080p@30fps", "720p@120fps", "video stabilization")
        ),
        array(
            "type" => "list",
            "name" => "Secondary",
            "value" => array("1.2 MP", "720p@30fps", "face detection", "FaceTime over Wi-Fi or Cellular")
        ),
        array(
            "type" => "category",
            "value" => "Features"
        ),
        array(
            "type" => "string",
            "name" => "OS",
            "value" => "iOS 7, upgradable to iOS 7.0.4"
        ),
        array(
            "type" => "string",
            "name" => "chipset",
            "value" => "Apple A7"
        ),
        array(
            "type" => "string",
            "name" => "CPU",
            "value" => "Dual-core 1.3 GHz Cyclone (ARM v8-based)"
        ),
        array(
            "type" => "string",
            "name" => "GPU",
            "value" => "PowerVR G6430 (quad-core graphics)"
        ),
        array(
            "type" => "list",
            "name" => "Sensors",
            "value" => array("Accelerometer", "gyro", "proximity", "compass")
        ),
        array(
            "type" => "list",
            "name" => "Messaging",
            "value" => array("iMessage", "SMS (threaded view)", "MMS", "Email", "Push Email")
        ),
        array(
            "type" => "string",
            "name" => "Browser",
            "value" => "HTML (Safari)"
        ),
        array(
            "type" => "bool",
            "name" => "Radio",
            "value" => false
        ),
        array(
            "type" => "list",
            "name" => "Location",
            "value" => array("GPS", "GLONASS")
        ),
        array(
            "type" => "bool",
            "name" => "JAVA",
            "value" => false
        ),
        array(
            "type" => "list",
            "name" => "Colors",
            "value" => array("Space Gray", "White/Silver", "Gold")
        ),
        array(
            "type" => "category",
            "value" => "Battery"
        ),
        array(
            "type" => "list",
            "name" => "Stand-by",
            "value" => array("Up to 250 h (2G)", "Up to 250 h (3G)")
        ),
        array(
            "type" => "list",
            "name" => "Talk time",
            "value" => array("Up to 10 h (2G)", "Up to 10 h (3G)")
        ),
        array(
            "type" => "list",
            "name" => "Music play",
            "value" => array("Up to 40 h")
        ),

        array(
            "type" => "category",
            "value" => "Tests"
        ),
        array(
            "type" => "list",
            "name" => "Display",
            "value" => array("Contrast ratio: 1219:1 (nominal)", "3.565:1 (sunlight)")
        ),
        array(
            "type" => "list",
            "name" => "Loudspeaker",
            "value" => array("Voice 68dB", "Noise 66dB", "Ring 69dB")
        ),
        array(
            "type" => "list",
            "name" => "Audio quality",
            "value" => array("Noise -93.6dB", "Crosstalk -90.3dB")
        ),
        array(
            "type" => "list",
            "name" => "Camera",
            "value" => array("Photo", "Video")
        ),
        array(
            "type" => "string",
            "name" => "Battery life",
            "value" => "Endurance rating 54h"
        ),
    ),
    "model_list" => array(
        array("name" => "Apple iPhone 5s", "url" => "#catalog/apple-iphone-5s.html"),
        array("name" => "Apple iPhone 4s", "url" => "#catalog/apple-iphone-4s.html"),
        array("name" => "Apple iPhone 5", "url" => "#catalog/apple-iphone-5.html"),
        array("name" => "Apple iPhone 4", "url" => "#catalog/apple-iphone-4.html"),
        array("name" => "Apple iPhone 5c", "url" => "#catalog/apple-iphone-5c.html"),
        array("name" => "Apple iPhone 3GS", "url" => "#catalog/apple-iphone-3gs.html"),
        array("name" => "Apple iPhone 3GS", "url" => "#catalog/apple-iphone-3g.html")
    )
);

$_GOOD_COMMENTS = array(
    "count" => 6,
    "list" => array(
        array(
            "date" => new DateTime("12/22/2013"),
            "id" => 987,
            "user" => "Walter White",
            "text" => "WARNING OVERPRICING FOR THIS DEVICE THIS DEVICE SELLS UNLOCKED FOR 650 FOR 16GB, 750 FOR 32GB, AND 850 FOR 64GB AND THE PHONE COMES LOCKED WITH CARRIER",
        ),
        array(
            "date" => new DateTime("12/22/2013"),
            "id" => 986,
            "user" => "Skyler White",
            "text" => "I ordered the new iPhone 5s to unlocked, paid more money for it, but they sent me a locked phone. I am travelling and very sad my phone does not work.",
        ),
        array(
            "date" => new DateTime("12/20/2013"),
            "id" => 986,
            "user" => "Jesse Pinkman",
            "text" => "A little history on my situation. I just upgraded from a Blackberry Storm 2. My wife has an iPhone 5 and previously had a Motorola Droid 2. These are the phones that I can compare to, so keep that in mind when reading my review.\n\nMy first impression out of box was that the phone was beautiful. I seriously didn't even want to touch it. I debated between space gray and white silver. I ultimately chose white silver because my wife has a black iPhone 5 and everything electronic I have is black. I though white was refreshing and if I can always put a case on to make it any color I want. I am so happy I chose white. It really makes the phone look fresh - sorry that is the best word I can find to describe it. The colors on the screen pop against the background. It doesn't show finger prints as much as my wives black phone.\n\nI got a clear case for the phone that just adds to the appearance. It also protects it from scratches and drops. In my opinion a case is required for an iPhone 5S. I honestly think that Apple designed it with the intent to use it with a case. Other competitive phones advertise a built in grip or that it feels better to hold than an iPhone, which is probably true. Apple made the phone so thin and light that adding a case just makes it feel better. Where other phones if you add a case it just makes the phone larger and heavier. I personally like putting my phone in a case. It is a way to personalize your phone and protect it. If the case gets dirty or worn, just spent $10 or $20 bucks and buy a new one.",
        ),
        array(
            "date" => new DateTime("12/19/2013"),
            "id" => 986,
            "user" => "Hank Schrader",
            "text" => "Here is my advice, if you can buy a Iphone 5s from the Istore or try to buy it unlocked from any carrier do it because here in Amazon they promise you a unlocked phone for 100 more dollars than its original price and guess what, you get a locked phone that has a AT&T gsm card, i live here in Venezuela, i bought a new nano sim for my phone and it didn't work, if you are out of United States and you want a Iphone 5s i recommend you to wait for it to arrive to your local carriers.",
        ),
        array(
            "date" => new DateTime("12/18/2013"),
            "id" => 986,
            "user" => "Marie Schrader",
            "text" => "I wasn't planning to buy this phone but life happened and I had to switch cell providers. I wanted the 5 (nice discount and I like the look of the black metal rather than the colored plastic of the 5c) but they were sold out. The store I was at happened to have 1 black (space grey) 16g left so I decided to go for it.\nI was upgrading from the 4s which I still think is a great phone. The 4g/LTE capabilities of the 5s are really great, the larger screen is also really great, but other than that the extras that are 5s exclusive are more of a gimmick at this point. The fingerprint sensor is a nice touch but not a necessity as your phone could still get hijacked. It does work pretty well and I like that you can program up to 5 fingerprints (I have thumb and index for both hands programmed on mine as well as the 4 digit pin) the camera is definitely better in low light, but I don't know of the dual flash actually makes a difference for me that is noticeable. The slow motion video camera is fun but I wish you could do more than one section in slow mo (can decide which section is slow mo but can't split it up. You also can't post slow mo to Instagram which is what I use video for mostly. Haven't tried with vine)",
        ),
        array(
            "date" => new DateTime("12/02/2013"),
            "id" => 986,
            "user" => "Saul Goodman",
            "text" => "The phone was locked. I Need to unlocked, haw can i do it?? Please help me. I live in Argentina, i can t send it back to replace it.",
        )
    )
);

$_ONLINE_USERS = array(
    "count" => 29,
    "users" => array(
        array(0, "Bryan"),
        array(1, "Anna"),
        array(2, "Aaron"),
        array(3, "Dean"),
        array(4, "Betsy"),
        array(5, "Mitte"),
        array(6, "Bob"),
        array(7, "Steven"),
        array(8, "Jonathan Banks"),
        array(9, "Giancarlo"),
        array(10, "Charles"),
        array(11, "Paul"),
        array(12, "Gunn"),
        array(13, "Jesse"),
        array(14, "Laura"),
        array(15, "Matt"),
        array(16, "Jones"),
        array(17, "Ray"),
        array(18, "Bob"),
        array(19, "Steven"),
        array(20, "Jonathan Banks"),
        array(21, "Giancarlo"),
        array(22, "Charles"),
        array(23, "Paul"),
        array(24, "Gunn"),
        array(25, "Jesse"),
        array(26, "Laura"),
        array(27, "Matt"),
        array(28, "Jones"),
    )
);


$_DATA = array(
    "shop_name" => "Yet another shop",
    "menu_list" => $_MAIN_MENU,
    "news_list" => $_NEWS,
    "blog_posts" => $_BLOG,
    "tizer_list" => $_TIZERS,
    "vendor_list" => $_VENDORS,
    "good_menu_list" => $_GOOD_MENU,
    "good" => $_GOOD,
    "comments" => $_GOOD_COMMENTS,
    "online" => $_ONLINE_USERS
);

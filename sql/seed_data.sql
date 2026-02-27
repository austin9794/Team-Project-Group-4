-- USERS
INSERT INTO users (name, email, password, role, phone, password_changed)
VALUES
('Bryan Singer', 'BryanS231@gmail.com',
 '$2y$12$6ieDfoEBai1QyKn.w/w7t.nBDvQlzeB214Lbi.M3aJCnsFoc.qIh6', -- admin123
 'admin', '0123456789', 0),

('John Doe', 'johndoe34@gmail.com',
 '$2y$12$9j2iiA.J4z8ewxPT8lPLfOuALEjvO4F0zVHZxPAUu.CJF2pRp7F3y', -- customer456
 'customer', '07891234567', 1),

('Sarah Khan', 'SarahK89@gmail.com',
 '$2a$12$prfqmD/9QZ6.agbibbikJOXPVq0e.5ny1SYAceIIq1.WD6Qvij5hm', -- customer789
 'customer', '07452309761', 1);

-- Insert 5 Categories --

INSERT INTO categories (name, description)
VALUES
('Keyboards', 'Mechanical, wireless, and gaming keyboards'),
('Mice', 'Wired, wireless, and ergonomic mice'),
('Headsets', 'Wired and wireless audio headsets'),
('Monitors', 'Gaming, portable, and 4K monitors'),
('Microphones', 'USB, wireless, and studio microphones');


-- PRODUCTS (25 total)
INSERT INTO products (category_id, name, slug, description, price, stock, low_stock_threshold) VALUES

-- KEYBOARDS (category_id = 1)
(1,'TECKNET RGB Gaming Keyboard', 'keyboard1',
 'Ergonomic Design & Gaming Comfort: Experience mechanical feel hand comfort with TECKNET RGB gaming keyboard scientific stepped keycap design and ergonomic typing angle (7°). The silent keys coupled with a wrist rest ensure hours of comfortable gaming or typing sessions. |
  Vivid Dynamic Backlit RGB Lighting: Immerse in the vibrant hues of 15 RGB color modes on TECKNET wired gaming keyboard English QWERTY layout. Each key is individually backlit, setting the perfect ambiance for your gaming station. |
  Sturdy All-Metal Panel Construction Keyboard: Constructed with a robust all-metal panel, UK layout, the TECKNET RGB gaming keyboard is engineered for endurance. |
  Pro-Level RGB Gaming Keyboard: Featuring 12 multimedia keys and 25 anti-ghosting keys, TECKNET gaming keyboard UK layout guarantees an uninterrupted gaming experience. |
  Energy Saving & Lighting Control: The TECKNET wired USB keyboard is powered directly from your computer — no batteries or charging needed. The backlight stays on by default to create a vibrant gaming atmosphere, and you can easily toggle the lights on or off  ',
 32.99, 30, 10),

(1,'CORSAIR K55 RGB PRO Wired Gaming keyboard', 'keyboard2',
 'Dynamic RGB Backlighting: Light up your desktop with six onboard lighting effects, assign a colour to each lighting zone, or program your own vibrant lighting effects with CORSAIR iCUE software. |
 Six Dedicated Macro Keys: Activate functions, shortcuts, or keypresses in just one stroke with six dedicated macro keys, easily set up through CORSAIR iCUE software or use Elgato Stream Deck software. |
 Dust and Spill-Resistant Design: IP42-rated protection guards against accidents so your gameplay never has to stop. |
 Detachable Palm Rest: A soft rubber palm rest reduces stress on your hands so you can play longer in comfort, with a textured surface to keep your hands from slipping. |
 Quiet and Responsive Keys: For comfortable typing during both work and play, with a tactile bump for responsive gaming performance.',
 59.99, 50, 10),

(1,'AULA F75 Wireless Mechanical Keyboard', 'keyboard3',
 'Tri-mode Connection Keyboard:AULA F75 wireless mechanical keyboard supports suitable for Bluetooth, 2.4GHz wireless and USB wired connection, can connect up to five devices at the same time, and easily switch by shortcut keys or side button.|
 Advanced Structure and PCB Single Key Slotting:This thock heavy mechanical keyboard features a advanced structure, extended integrated silicone pad, and PCB single key slotting, better optimizes resilience and stability, making the hand feel softer and more elastic.|
 Side Engraved Gaming Keyboard:No matter the outlook, the construction, or the function, F75 mechanical keyboard is definitely a professional gaming keyboard.This 81-key 75% layout compact keyboard can save more desktop space while retaining the necessary arrow keys for gaming.|
 Hot-swap Custom Keyboard:This custom mechanical keyboard with hot-swappable base supports 3-pin or 5-pin switches replacement. Even keyboard beginners can easily DIY there own keyboards without soldering issue.|
 16.8 Million RGB Backlit Keyboard:F75 light up led keyboard features 16.8 million RGB lighting color. With 16 pre-set lighting effects to add a great atmosphere to the game. And supports 10 cool music rhythm lighting effects with driver. Lighting brightness and speed can be adjusted by the knob or the key combination. You can select the single color effect as wish. And if you can turn the backlight off if you do not need it.|',
 82.99, 40, 10),

(1,'UGREEN Wireless Bluetooth Keyboard', 'keyboard4',
 'Two Connection Modes: UGREEN wireless keyboard supports bluetooth and 2.4GHz USB connection. You can easily switch modes and connect the keyboard to up to 3 devices at the same time, such as laptop, PC and tablet.|
 Fast-Rechargeable and Long Battery Life: The keyboard comes with a charging cable, no additional batteries are required, and a full charge takes only 2 hours, allowing for 90 days of continuous use. This saves you money on batteries and is more environmentally friendly.|
 Ultra-Portable Mini Keyboard: This mini keyboard is only L36.5cm*W12.3cm*H2.07cm, which saves desk space when used indoors and is also easy to carry for outdoor travel and business trips.|
 Wide Compatibility: The wireless keyboard is compatible with Windows/MacOS/IpadOS/Linux/Chrome OS/Android, Ipad/PC/Laptop, etc. You can easily use it on multiple devices without worrying about compatibility issues.|
 Driver-free Use: No need to install additional drivers or software, it can be used after connection, meeting your emergency use needs, and supports a control distance of up to 10 meters.',
 27.99, 35, 10),

(1,'SteelSeries Apex Pro TKL Gen 3', 'keyboard5',
 'THE WORLDS FASTEST KEYBOARD — More than just fast, our newly redesigned Hall Effect Switch have 20x faster actuation and 11x quicker response time, with 40 levels of adjustable actuation.|
 OMNIPOINT 3.0 — Push the boundaries with cutting-edge OmniPoint 3.0 switches with Rapid Trigger, Protection Mode, Rapid Tap and full adjustability.|
 GAME-READY PRESETS — Gain a competitive edge in your favorite game with just a few clicks using GG QuickSets game-ready keyboard settings.|
 REUCED LATENCY — Rapid Trigger and Rapid Tap register keypresses faster for more responsive game play and improved aim.|
 PROTECTION MODE — A SteelSeries exclusive feature — protect your keypresses by reducing the sensitivity of surrounding keys when the intended key is pressed, preventing accidental inputs.',
 209.99, 60, 10),

-- MICE (category_id = 2)
(2,'Logitech G305 LIGHTSPEED Wireless Gaming Mouse', 'mouse1',
 'HERO Gaming Sensor : Next-gen Hero mouse sensor delivers up to 10x the power efficiency over other gaming mice with exceptional accuracy and responsiveness thanks to 400 IPS precision and up to 12000 DPI sensitivity.|
 LIGHTSPEED Wireless : Ultra-fast Lightspeed Wireless technology gives you a lag-free gaming experience. The G305 wireless gaming mouse delivers incredible responsiveness and reliability with a super-fast 1ms report rate for competition-level performance.|
 Ultra-Long Battery Life : The G305 wireless Logitech mouse boasts an incredible 250 hours of continuous gameplay on a single AA battery so you can play at peak performance without worrying about running out of power.|
 Lightweight design : Thanks to an efficient mechanical design, the G305 gaming mouse weighs in at only 99 grams for high manoeuvrability.|
 Portable Convenience : The durable, compact design with built-in nano receiver storage makes the G305 not just a great computer mouse, but also an excellent laptop mouse.',
 59.99, 45, 10),

(2,'Apple Magic Mouse', 'mouse2',
 'Magic Mouse is wireless and rechargeable, with an optimised foot design that lets it glide smoothly across your desk.|
 The Multi-Touch surface allows you to perform simple gestures such as swiping between web pages and scrolling through documents.|
 The rechargeable battery will power your Magic Mouse for about a month or more between charges.|
 It’s ready to go straight out of the box and pairs automatically with your Mac, and it includes a woven USB-C Charge Cable that lets you pair and charge by connecting to a USB-C port on your Mac.',
 79.99, 80, 10),
 
(2,'Logitech G502 High Performance Wired Gaming Mouse', 'mouse3',
 'HERO 25K Sensor: The next generation of the HERO optical sensor brings new precision to your mouse at up to 25,600 DPI while generating no smoothing, filtering or acceleration. USB report rate: 1000 Hz (1 ms).|
 11 Programmable Buttons and Ultra-Fast Dual-Mode Scroll Wheel: The Logitech G wired gaming mouse gives you full customization of your gaming settings.|
 Adjustable Weight: Adjust the glide of your mouse. five 3.6g weights come with the G502 HERO wired mouse to find the perfect setup and optimize your gaming performance.|
 LIGHTSYNC RGB: LIGHTSYNC technology gives you fully customizable RGB lighting, synchronize animations and lighting effects with your other Logitech G devices. Maximum acceleration: > 40 G.|
 Mechanical Button Tension System: Every click is crisper and more reliable thanks to a mechanical tension system with springs and pivots in the left and right buttons.|
 Next Generation Sensor: Capable of detecting sub-micron motion and tracking motion to less than a millionth of a meter with exceptional accuracy.',
 34.99, 55, 10),

(2,'Anker 2.4G Vertical Ergonomic Mouse', 'mouse4',
 'Scientific ergonomic design encourages healthy neutral "handshake" wrist and arm positions for smoother movement and less overall strain.|
 800 / 1200 / 1600 DPI Resolution Optical Tracking Technology provides more sensitivity than standard optical mice for smooth and precise tracking on a wide range of surfaces.|
 Added next/previous buttons provide convenience when webpage browsing; the superior choice for internet surfers, gamers and people who work at length at the computer.|
 Enters power saving mode (power is cut off completely) after 8 minutes idle, press right or left button for it to wake. Product dimensions: 120*62.8*74.8 mm; product weight: 3.4 oz.|
 Package includes: 1 Anker Wireless Vertical Ergonomic Optical Mouse (2 AAA batteries not included), 1 2.4G USB receiver (in the bottom of the mouse), 1 instruction manual. 18-month hassle-free warranty.',
 23.99, 30, 10),
 
(2,'TECKNET Bluetooth Mouse', 'mouse5',
 '【Multi-Device Connectivity】TECKNETs rechargeable bluetooth wireless mouse allows seamlessly connects to multi devices, laptops, desktops or tablets. Easily switch between devices with a single click of the wireless mouse. Offers 2.4G and Bluetooth 5.0 / 3.0 connection.|
【Rechargeable and Energy-Efficient Design】This Type-C mouse comes with a 700mAh battery that lasts up to 3 months and can be used while charging. Rechargeable wireless mouse is more eco-friendly than computer mouse that require battery replacement. It also features an auto-sleep mode and low battery indicator.|
【Ultra Precise Tracking】This bluetooth mouse for laptop offers 6 adjustable DPI levels: 4800 3200/2400/1600/1200/800, which allows you to easily adjust the mouse cursor sensitivity according to your work task or gaming preference. Additionally, TECKNET TruWave optical tracking technology ensures the smoothest and most precise cursor control on most surfaces.|
【Silent Click】TECKNETs bluetooth wireless mouse with a mute design that reduce the noise level by up to 90%, this mouse is the ideal mouse for office, home and leisure use. Silent mouse with a durable build tested to endure over 6 million clicks.|
【Designed for Comfort & Productivity】Ergonomic mouse provides a natural fit for your hand, cutting down muscle strain by up to 30%—a real boon for intensive users. This wireless mouse for laptop with forward and backward buttons offer swift navigation, boosting your efficiency by as much as 150%, so you can breeze through tasks in no time. (Side buttons are not supported on MAC OS).',
 28.99, 90, 10),

-- HEADSETS (category_id = 3)
(3,'HyperX Cloud Alpha Gaming Headset', 'head1',
 'HyperX Dual Chamber Drivers for more distinction and less distortion.|
 Signature award-winning HyperX comfort. Sound pressure level:98dBSPL/mW at 1kHz.|
 Durable aluminium frame with expanded headband.|
 Detachable braided cable with convenient in-line audio control.|
 Detachable noise-cancellation microphone.|
 Multi-platform compatibility (on PC, PS4, PS5, Xbox One, Xbox Series X|S).',
 34.99, 25, 10),

(3,'Vakedy Wireless Gaming Headset', 'head2',
 '【50mm Driver Surround Stereo】Equipped with high-powered 50mm drivers, this gaming headset delivers premium stereo sound that’s clear, balanced, and rich in detail. Paired with lower latency (≤20ms) making gamer easy and quickly to pick up in game details in games for a better immersive gaming experience.|
 【Noise Canceling Microphone】HW20 Wireless gaming headphones feature a detachable and omnidirectional microphone with high-end noise cancellation while the flexible microphone provides clear communication with teammates when you are in a game or chat, it effectively reduces background noise to keep you focused. And the sturdy closed earcups fully enclose your ears to enhance sound isolation making the bluetooth headset is the ideal choice for multiplayer gaming and streaming.|
 【Up to 50H Battery Life】Wireless PC gaming headset boasts an impressive 50-hour continuous gameplay runtime with a voice alert for low power, and charging the over ear headphone fully takes only 3 hours. The battery life varies by usage, you might need to charge it every 3-4 days on light use or charge it every 1-2 days heavy use. Whether you’re gaming, chatting, or listening to music, it keeps up with your rhythm.|
 【Lightweight and Comfortable Ergonomic Design】Gaming headset features an adjustable headband that eases pressure on the head and ears—perfectly fitting various head shapes from children to adults. Its comfortable, breathable mesh ear cushions and lightweight design (just 8.8 ounces) ensure all day comfort, even during extended gaming marathons. And the microphone is accented with LED lights, adding a unique flair to the headset while amplifying the immersive gaming atmosphere, making it an ideal gift for girls and boys, teens and adults.',
 149.99, 40, 10),
 
(3,'Jabra Evolve 20 Stereo Headset', 'head3',
 'Passive noise cancellation for ideal concentration: Keeps high-frequency noise such as human voices out for better work collaboration and listening experience in any environment.|
 Easy call management: External sound controller allows for making, taking and muting calls – Stay connected and available at all times.|
 This Evolve 20 headset is Microsoft Certified and built for style and comfort with soft foam ear cushions – Adjustable headband lets you find the perfect fit.|
 Plug-and-play setup: The headset works out of the box with all leading systems – Installation is as easy as simply plugging it in.|
 Scope of delivery: Jabra Evolve 20 stereo on-ear headset, USB cable with control unit – Weight: 171g – Colour: black.',
 34.99, 70, 10),

(3,'beyerdynamic DT 990 PRO 250 Ohm Open Dynamic Studio Headphones',  'head4',
 'Open backed over-ear headphones, ideal for professional mixing, mastering and editing.|
 Perfect for studio applications thanks to their transparent, spacious, strong bass and treble sound.|
 The soft, circumaural and replaceable velour ear pads ensure high wearing comfort.|
 Robust, comfortably padded and adjustable spring steel frame construction.|
 Coiled connection cable with a 3.5 mm jack plug and 6.35 mm adapter included with a headphone frequency response of 5 -35000 Hz.|
 Compatible with HEADPHONE LAB – the virtual reference studio takes your beyerdynamic headphones to the next level: Mix with the free studio plug-in as if you were in a professional recording studio.',
 138.99, 15, 10),
 
(3,'JLab Go Work 2nd Gen Wireless Headset', 'head5',
 'DUAL CONNECTIVITY WITH BLUETOOTH MULTIPOINT: Connect the wireless headset via USB-C dongle or Bluetooth 5.3 to your PC, Mac, office computer, mobile and more. Or plug-in the included Type-C to Type-C cable for wired laptop headphones with microphone. Connect to 2 devices simultaneously with Multipoint.|
 CLEAR CALLS WITH NOISE CANCELLING MIC: C3 Calling uses dual mics on each Bluetooth headset with microphone - one captures your voice while the other eliminates environmental noise, talking and background sound for crystal clear calls anytime, anywhere.|
 IMPROVED ALL-WEEK PLAYTIME AND COMFORT: Get 55+ hours of playtime on one charge with your overhead bluetooth headset with mic for work - and all-day comfort with Cloud Foam earcups. Rotate the boom microphone for listening only – and down to take a teams call or video conference meeting.|
 TOTAL CONTROL AND QUICK MUTE INDICATOR: Play/pause, answer/reject, volume, mute and track control with the multi-functional buttons located on the computer headsets. Choose between 2 EQ settings: Work or Music mode. Quickly toggle the mute function via the controls on the office headset with microphone for laptop. A red LED at the end of the boom mic indicates whether mute is on.|
 PC HEADSET INCLUDES: GO Work 2nd Gen on-ear office or gaming laptop headset with microphone, USB-C dongle, Type-C to Type-C cable for wired use, JLab Two Year Warranty. Perfect for everyday office life! Enjoy clear calls and Zoom video calls and never forget to un-mute with the mute-indicator-light.',
 49.99, 50, 10),

-- MONITORS (category_id = 4)
(4,'Philips 27E1N1100A - 27 Inch FHD Monitor', 'monitor1',
 'Built-in stereo speakers for multimedia.|
 HDMI ensures universal digital connectivity.|
 LowBlue mode and Flicker-free easy-on-the eyes viewing.|
 Cable management reduces cable clutter for neat workspace.|
 Cable management reduces cable clutter for neat workspace.|
 EasySelect menu toggle key for quick on-screen menu access.',
 94.99, 20, 10),

(4,'ASUS TUF Gaming VG279QM1A Gaming Monitor', 'monitor2',
 '27-inch Full HD(1920x1080) gaming monitor with overclock to 280Hz refresh rate designed for professional gamers and immersive gameplay.|
 ASUS Extreme Low Motion Blur Sync (ELMB Sync) technology enables ELMB and variable-refresh-rate technologies to work simultaneously to eliminate ghosting and tearing for sharp gaming visuals with high frame rates.|
 FreeSync Premium and G-Sync compatible delivers a seamless, tear-free gaming experience by enabling VRR (variable refresh rate) by default.|
 High Dynamic Range (HDR) technology supports HDR-10 format to enhance bright and dark areas.',
 129.99, 20, 10),
 
(4,'Minifire 27" 180Hz Curved Monitor', 'monitor3',
 'Massive 27" Curved VA Display：Immerse yourself in FHD 1080P clarity with a 200Hz refresh rate, delivering buttery-smooth gameplay and cinematic visuals. Perfect for competitive gaming and multitasking.|
 1ms Response + FreeSync Premium：Zero ghosting or screen tearing in fast-paced games like Apex Legends or Forza. Adaptive sync ensures fluid frame rates across PC/console setups.|
 Vivid Colors & HDR：130% sRGB + HDR compatibility brings lifelike detail to games, movies, and creative work. 300cd/m² brightness ensures sharp contrast in dark scenes.|
 Built-in Speakers + Frameless Design：Save space with integrated audio, while the sleek edge-to-edge design adds modern style to your desk. Curved ergonomics reduce eye strain during long sessions.|
 Flexible Ports + Free HDMI Cable：HDMI 1.4/DP 1.2 ports connect to PS5/Xbox/PC. Includes a free MFG27C1 HDMI cable for instant plug-and-play.',
 144.99, 25, 10),

(4,'MSI PRO MP275 27 Inch Full HD Office Monitor', 'monitor4',
 '27-INCH FHD PANEL - The PRO MP275 features a large 27-inch IPS panel with Full-HD (1920x1080) resolution; A high 100Hz refresh rate improves the day-to-day visual experience with smoother, faster frame rates.|
 IMAGE QUALITY - The PRO MP275 supports a 93% sRGB Colour Gamut (6-bit+FRC, 16.7M colours), 300 nits brightness & superior 1000:1 Contrast Ratio; MSI Display Kit App unlocks extra display, productivity & colour settings.|
 EYE COMFORT ORIENTED - MSI EyesErgo solution includes TÜV Rheinland Eye Comfort certified Less Blue Light & Anti-Flicker technology as well as Eye-Q Check software to prevent strain during extended periods of use; Anti-glare surface treatment.|
 SIMPLE YET FLEXIBLE - The monitor comes with 100mm VESA brackets for wall or arm mounting (e.g., MSI VESA Arm MT81), while the stand is Tilt Adjustable & includes a Handy Cable Management clip; Built-in 2W Speakers are convenient for conference calls.|
 MODERN & LEGACY CONNECTIVITY - Supports Multi-System Control & display with HDMI 1.4b and D-Sub (VGA) ports; Includes a headphones-out jack and line-in port.',
 109.99, 20, 10),
 
(4,'LG MONITOR 27 inch, 120 Hz, 5ms GtG, Computer desktop', 'monitor5',
 '120Hz REFRESH RATE - A fast 120Hz provides a smooth frame loading in various programs.|
 Brilliant Image Quality in Full HD IPS Display – The 27-inch Full HD (1920x1080) IPS Display with sRGB 99% colour gamut & HDR10 that reproduces vivd colours and detailed images.|
 Reader Mode adjusts colour temperature and luminance, supporting a suitable viewing experience for reading on a monitor. Flicker Safe reduces invisible flickering on the screen.|
 This display has a slim bezel on three sides, allowing you to create a suitable work environment through convenient tilt adjustment.',
 89.99, 25, 10),

-- MICROPHONES (category_id = 5)
(5,'TONOR RGB USB Microphone', 'mic1',
 'Unrivaled Audio Quality: The TC310+ gaming mic equiped premium chips and core, coupled with expert tuning by engineers, resulting in ultra-low noise levels and a pure, clean sound. It delivers crystal-clear clarity and full-bodied sound, providing high-fidelity reproduction that brings your recordings to life. Whether youre a gamer, podcaster, or YouTuber, the TC310+ ensures that your voice will be heard loud and clear.|
 Vibrant RGB lighting: Here are 4 RGB modes to choose from, including six solid color static, single-color gradient, single-color breathing, and mix-color gradient. Simply touch the lighting icon on the device, select your favorite lighting effect, and create a stunning visual experience!Of course, you can also turn off the RGB lights by long-tapping the lighting icon.|
 Brightness Control: Adjust the brightness of the RGB lights by simply rotating the bottom of the usb microphone, creating the perfect lighting atmosphere to suit your needs.|
 Convenient Sound Control: Easily mute it by tapping the top of the gaming mic, allowing you to turn off the microphones sound during live streaming or gaming. Rotating the top of the microphone makes it easy to adjust the microphones gain, ensuring that you maintain an appropriate volume at all times. All of these operations are simple and convenient, and can be completed in an instant, giving you complete control.|
 Enhanced Boom Arm Kit: The gaming mic is equipped with a boom arm mounting kit. The metal-made boom arm is sturdy enough and the clamp perfectly fits most desks with a thickness not exceeding 2.36''. Both the boom arm and the microphone are adjustable, allowing you to easily adjust the microphone to the appropriate angle or height to showcase your perfect sound.',
 49.99, 30, 10),

(5,'FIFINE XLR/USB Dynamic Microphone', 'mic2',
 '[XLR Connection for Upgraded Audio] Featured with high accuracy and decent transmission performance, the XLR dynamic microphone worked with frequency response range of 50Hz-16KHz presents transparent, open and authentic vocal voice. Due to studio recording mic with S/N Ratio more than 80dB, even if you record in a sub-optimal space, your voice will not be drown out by ambient noise. The dynamic cardioid podcast microphone creates audio near enough as close to real life.|
 [USB Connection Featured RGB] The USB gaming microphone gives a directly easy running with, meeting your daily game voice needs. The USB podcast microphone provides the key to live streaming with clear and balanced voice.When you stream media recording, the RGB microphone lighting is eye-catching enough to enrich your program. RGB lighting can also be customized with controls, switches, color switching, and color change modes to meet your different needs for daily gaming or work recording.|
 [Mute Button and Gain Knob] Function keys are located easy to access quickly for you adjust the vocal volume. The computer microphone allows you to continue to type on keyboards without disturbing. Tap-to-mute button avoids distractions in the background and makes people hear you again shortly. Dial mic gain instead of calling too loud or low when gaming, streaming or podcasting.|
 [Headphones Monitoring and Adjustment] The desktop gaming microphone has monitoring headphones jack with discrete volume adjustment to let you hear mic input with the audio. It is convenient to do microphone tests before going live. You can hear how loud you are being, especially when setting up the gain you need. The PC gaming microphone improves your rhythm gaming experience or podcast.|
 [Compatibility and Use] XLR/USB microphone is a one stop shop for audio content, suitable for beginner. Thanks to hybrid connection, you can start using USB connection, and when youre ready to get into XLR gear. You can use the USB port directly with the desktop/laptop to play game voice on Twitch or Discord (compatible with PS4/PS5). Or, use XLR port with audio interface or mixer to upgrade studio recording.',
 56.99, 75, 10),
 
(5,'UGREEN 24bit/96KHz Condenser Microphone', 'mic3',
 'Crystal Clear Sound Quality: This condenser microphone operates at a high resolution up to 24bit/96kHz. This USB streaming mic captures voice with a rich tone, natural, ensuring your vocals sound full and detailed without compressed. In addition, the noise-cancelling mode can effectively reduces background noise such as keyboard clacking, mouse clicks, or general room hum, ensuring that your voice remains the focus. Ideal for professional gaming, recording, podcasting, and live streaming.|
 One-Touch DSP Noise Cancellation: Press and hold the top button for 2 seconds to instantly activate advanced DSP noise reduction—silencing background distractions so your voice stays clear and professional.|
 7 RGB Lighting Effects: This gaming mic integrated appealing phantom light effect + 5 monochrome lights + colourful breathing light to enhance the visual appeal of your setup. Perfect to improve audio/visual quality during streaming. The RGB lights also turn off when the pc microphone is muted, making it easy to see when you are being recorded.|
 Practical and Convenient: This gaming microphone also has a mode indicator, so you can clearly see the microphones status. There is also a continuously adjustable knob for easily adjustingmicrophone volume. There is a 3.5mm headphone jack in the middle so you can connect the headphones for real-time monitoring and make adjustments for better audio quality.|
 Desktop-Friendly Design: This PC microphone features a solid base and an adjustable stand to help minimise vibrations and unwanted noise, ensuring clean and clear recordings. With a standard 3/8 threaded connector on the underside of the stand, you can connect it to a cantilever bracket to suit your needs.',
 36.99, 50, 10),
 
(5,'MAONO USB Noise-Cancellation Mic', 'mic4',
 'MORE FOCUS AND CLARITY - This gaming microphone with one-click noise cancellation technology, which can effectively eliminate background noise. Whether its multiplayer online games, cooperative games, or competitive games, the USB microphone can capture game players voices clearly, thereby enhancing the collaboration and competitiveness of the game. Cardioid pickup focuses more on capturing sound from the mic front, providing better sound quality and accuracy for gaming streaming or voice.|
 CONTROLLABLE RGB LIGHTING - You can change the color of RGB lights to match your game streaming aesthetic. The computer microphone has 9 personalized RGB lighting modes, Soft and coordinated lighting effects make your gaming video or gaming live broadcast stand out from the crowd. Long-pressing the RGB button turns off the RGB lights, while a short press turn on the lights and adjusts the light color.|
 EASIER MULTIFUNCTION USE - One-click the mute button on top of the PC microphone to turn on mute mode, and you can easily control your game audio. Take control of your on-stream sound with the mic gain knob, you can check if your voice level is too high or too low and adjust accordingly. The zero-latency monitoring allows you to easily maintain professional sound quality with a gaming mic.|
 PLUG AND PLAY - The game streaming microphone is compatible with Windows PC computer laptop, Mac, and PS4/5. The gaming USB microphone is ready to capture it when inspiration strikes. Just plug the mic straight into your computer or laptop with the included USB and USB C cable, and youre all set to record or stream, right away, No drivers are required. (Note: Not compatible with XBOX).|
 STURDY & FLEXIBLE ARM STAND - The easy-to-position metal arm stand adjusts to support a variety of setups, You can quickly pull the podcast microphone near your mouth when in use, or fold it away to save more space. The shock mount can further reduce game-induced machine noise and vibration, and the removable pop filter can reduce noise without blocking the gaming computer screen.',
 52.99, 18, 10),

(5,'HyperX QuadCast 2 S – USB Microphone', 'mic5',
 'FUTURE READY AUDIO: The QuadCast 2 S features best-in-class audio recording resolution on a consumer USB gaming microphone.on a consumer USB gaming microphone.|
 DYNAMIC LIGHTING DISPLAY: QuadCast 2 S has over 100+ individually customizable aRGB LEDs allowing users to display over 16M+ color options to complement their streams and creations.|
 TAP-TO-MUTE SENSOR: The Tap-to-Mute sensor allows users to quickly mute/unmute the mic to manage what is heard.|
 REDESIGNED DETACHABLE SHOCK MOUNT: The pre-attached vibration-dampening shock mount is easily detachable thanks to the spring-loaded pins. The shock mount joint is also compatible with 3/8” and 5/8” threading, for easy setups.|
 VERSATILE MULTIFUNCTION KNOB: The multifunction knob allows users to easily select and adjust microphone gain, headphone volume, monitor mix, and the desired polar pattern.|
 FOUR SELECTABLE POLAR PATTERNS: QuadCast 2 S offers four polar patterns (cardioid, omnidirectional, bi-directional, or stereo) to fit a wide variety of recording needs.',
 94.99, 60, 10);

-- Product Images

-- HEADSET 1 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head1/01.png', 1, 1
FROM products WHERE slug = 'head1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head1/02.png', 0, 2
FROM products WHERE slug = 'head1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head1/03.png', 0, 3
FROM products WHERE slug = 'head1';

-- HEADSET 2 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head2/01.png', 1, 1
FROM products WHERE slug = 'head2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head2/02.png', 0, 2
FROM products WHERE slug = 'head2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head2/03.png', 0, 3
FROM products WHERE slug = 'head2';

-- HEADSET 3 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head3/01.png', 1, 1
FROM products WHERE slug = 'head3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head3/02.png', 0, 2
FROM products WHERE slug = 'head3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head3/03.png', 0, 3
FROM products WHERE slug = 'head3';

-- HEADSET 4 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head4/01.png', 1, 1
FROM products WHERE slug = 'head4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head4/02.png', 0, 2
FROM products WHERE slug = 'head4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head4/03.png', 0, 3
FROM products WHERE slug = 'head4';

-- HEADSET 5 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head5/01.png', 1, 1
FROM products WHERE slug = 'head5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head5/02.png', 0, 2
FROM products WHERE slug = 'head5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head5/03.png', 0, 3
FROM products WHERE slug = 'head5';

-- KEYBOARD 1 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard1/01.png', 1, 1
FROM products WHERE slug = 'keyboard1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)                 
SELECT product_id, 'products/keyboards/keyboard1/02.png', 0, 2
FROM products WHERE slug = 'keyboard1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard1/03.png', 0, 3
FROM products WHERE slug = 'keyboard1';

-- KEYBOARD 2 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard2/01.png', 1, 1
FROM products WHERE slug = 'keyboard2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard2/02.png', 0, 2
FROM products WHERE slug = 'keyboard2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard2/03.png', 0, 3
FROM products WHERE slug = 'keyboard2';

-- KEYBOARD 3 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard3/01.png', 1, 1
FROM products WHERE slug = 'keyboard3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard3/02.png', 0, 2
FROM products WHERE slug = 'keyboard3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard3/03.png', 0, 3
FROM products WHERE slug = 'keyboard3'; 

-- KEYBOARD 4 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard4/01.png', 1, 1
FROM products WHERE slug = 'keyboard4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard4/02.png', 0, 2
FROM products WHERE slug = 'keyboard4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard4/03.png', 0, 3
FROM products WHERE slug = 'keyboard4';

-- KEYBOARD 5 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard5/01.png', 1, 1
FROM products WHERE slug = 'keyboard5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard5/02.png', 0, 2
FROM products WHERE slug = 'keyboard5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard5/03.png', 0, 3
FROM products WHERE slug = 'keyboard5';

-- MICROPHONE 1 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic1/01.png', 1, 1
FROM products WHERE slug = 'mic1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic1/02.png', 0, 2
FROM products WHERE slug = 'mic1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic1/03.png', 0, 3
FROM products WHERE slug = 'mic1';

-- MICROPHONE 2 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic2/01.png', 1, 1
FROM products WHERE slug = 'mic2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic2/02.png', 0, 2
FROM products WHERE slug = 'mic2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic2/03.png', 0, 3
FROM products WHERE slug = 'mic2';

-- MICROPHONE 3 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic3/01.png', 1, 1
FROM products WHERE slug = 'mic3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic3/02.png', 0, 2
FROM products WHERE slug = 'mic3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic3/03.png', 0, 3
FROM products WHERE slug = 'mic3';

-- MICROPHONE 4 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic4/01.png', 1, 1
FROM products WHERE slug = 'mic4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic4/02.png', 0, 2
FROM products WHERE slug = 'mic4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic4/03.png', 0, 3
FROM products WHERE slug = 'mic4';

-- MICROPHONE 5 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic5/01.png', 1, 1
FROM products WHERE slug = 'mic5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic5/02.png', 0, 2
FROM products WHERE slug = 'mic5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic5/03.png', 0, 3
FROM products WHERE slug = 'mic5';

-- MONITOR 1 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor1/01.png', 1, 1
FROM products WHERE slug = 'monitor1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor1/02.png', 0, 2
FROM products WHERE slug = 'monitor1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor1/03.png', 0, 3
FROM products WHERE slug = 'monitor1';

-- MONITOR 2 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor2/01.png', 1, 1
FROM products WHERE slug = 'monitor2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor2/02.png', 0, 2
FROM products WHERE slug = 'monitor2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor2/03.png', 0, 3
FROM products WHERE slug = 'monitor2';

-- MONITOR 3 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor3/01.png', 1, 1
FROM products WHERE slug = 'monitor3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor3/02.png', 0, 2
FROM products WHERE slug = 'monitor3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor3/03.png', 0, 3
FROM products WHERE slug = 'monitor3';

-- MONITOR 4 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor4/01.png', 1, 1
FROM products WHERE slug = 'monitor4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor4/02.png', 0, 2
FROM products WHERE slug = 'monitor4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor4/03.png', 0, 3
FROM products WHERE slug = 'monitor4';

-- MONITOR 5 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor5/01.png', 1, 1
FROM products WHERE slug = 'monitor5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor5/02.png', 0, 2
FROM products WHERE slug = 'monitor5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor5/03.png', 0, 3
FROM products WHERE slug = 'monitor5';

-- MICE 1 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse1/01.png', 1, 1
FROM products WHERE slug = 'mouse1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse1/02.png', 0, 2
FROM products WHERE slug = 'mouse1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse1/03.png', 0, 3
FROM products WHERE slug = 'mouse1';

-- MICE 2 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse2/01.png', 1, 1
FROM products WHERE slug = 'mouse2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse2/02.png', 0, 2
FROM products WHERE slug = 'mouse2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse2/03.png', 0, 3
FROM products WHERE slug = 'mouse2';

-- MICE 3 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse3/01.png', 1, 1
FROM products WHERE slug = 'mouse3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse3/02.png', 0, 2
FROM products WHERE slug = 'mouse3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse3/03.png', 0, 3
FROM products WHERE slug = 'mouse3';

-- MICE 4 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse4/01.png', 1, 1
FROM products WHERE slug = 'mouse4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse4/02.png', 0, 2
FROM products WHERE slug = 'mouse4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse4/03.png', 0, 3
FROM products WHERE slug = 'mouse4';

-- MICE 5 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse5/01.png', 1, 1
FROM products WHERE slug = 'mouse5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse5/02.png', 0, 2
FROM products WHERE slug = 'mouse5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse5/03.png', 0, 3
FROM products WHERE slug = 'mouse5';

-- ADDRESSES

INSERT INTO addresses 
(user_id, label, full_name, address_line1, address_line2, city, county, postcode, country, is_default, created_at)
VALUES

-- User 2
(2, 'Home', 'Ali Khan',
 '12 High Street',
 NULL,
 'Birmingham',
 'West Midlands',
 'B1 1AA',
 'United Kingdom',
 1,
 NOW()),

-- User 3
(3, 'Home', 'Sarah Khan',
 '45 Queen Road',
 NULL,
 'London',
 NULL,
 'E1 6AN',
 'United Kingdom',
 1,
 NOW());


-- EXAMPLE ORDER
INSERT INTO orders
(user_id, total_price, status, address_id)
VALUES
(2, 32.99, 'pending', 1),
(3, 149.99, 'processing', 2),
(2, 24.99, 'shipped', 1);


INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase)
VALUES
(1, 1, 1, 32.99),
(2, 3, 1, 39.99),
(3, 2, 1, 149.99);


-- REVIEWS
INSERT INTO reviews (product_id, order_item_id, user_id, rating, comment)
VALUES
(1, 1, 2, 5, 'Excellent feel and nice to use!'),
(3, 2, 3, 4, 'Good sound quality.');

-- INVENTORY LOGS
INSERT INTO inventory_logs
(product_id, change_amount, action, admin_id)
VALUES
(1, -1, 'purchase', 1),
(2, -1, 'purchase', 1),
(2, 10, 'restock', 1),
(3, -5, 'manual_adjust', 1);

-- ADMIN ACTIONS
INSERT INTO admin_actions
(admin_id, action_type, description)
VALUES
(1, 'PROCESS_ORDER', 'Order #2 marked as processing'),
(1, 'RESTOCK', 'Restocked Vakedy Wireless Headset by 10 units'),
(1, 'PRODUCT_UPDATE', 'Updated stock threshold for Logitech G203');

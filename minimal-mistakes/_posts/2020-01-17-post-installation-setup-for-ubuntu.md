---
title: "Post-Installation Setup for Ubuntu 20.04 on Dell XPS 13 7390"
description: "Good-to-make improvements and enhancements for your freshly installed Ubuntu 19.10"
tags: [Ubuntu, Mac, Linux, Keyboard, Hotkeys]
---
After being a macOS user since 2014, I recently switched to Ubuntu on my new Dell XPS. This post talks about the changes I had to make to ensure a smoother transition. It also serves as a guide for setting up a new Ubuntu machine ready for development!

## Remapping Keyboard Keys
If there is one thing that I can't compromise on, it is my keyboard shortcuts that I got accustomed to over years that I absolutely can not live without! Plus, if you are somebody who has to juggle between different operating systems, remapping is a blessing sent directly from heavens!

### **Get Mac keyboard layout on Ubuntu**
In Mac a lot of main functions such as switching tabs, creating new windows, etc is done with the Command key. If you are a programmer who uses terminal often, then you know there is also a heavy usage of the Ctrl key for tasks such as sending terminating signal via "Ctrl+C". However, in Ubuntu both of these types of functions are performed alone by the Ctrl key. The conflicts are generally resolved by adding additional keys to the commands. For example, copying in Ubuntu is "Ctrl+Shift+C" since "Ctrl+C" is already taken as mentioned earlier. This problem doesn't arise in Mac since copying is "Command+C" and terminating is "Ctrl+C".

Despite of all the things that I don't like about MacOS, I must admit I prefer Mac's keyboard layout over Ubuntu's. There is no need to make commands longer when we can easily delegate tasks to different keys. To get Mac's Command and Ctrl keys functionalities, I use Ubuntu's Alt key and make it perform the functions of MacOS's Ctrl key. I then swap my left Ctrl and left Alt keys to make the positions match the Command and Ctrl keys as on a Mac keyboard.

Following are the steps to do so,

- Install xmodmap via xkeycaps: `sudo apt install xkeycaps`
- Install autokey: `sudo apt-get install autokey-gtk`
- First, swap the left Alt key with the left Ctrl key so that later remappings are more intuitive
  - Create ~/.Xmodmap if it doesn't exist otherwise append the following to it

    ```shell
    ! swap left control and alt keys
    clear control
    clear mod1
    keycode 37 = Alt_L Meta_L
    keycode 64 = Control_L
    add control = Control_L Control_R
    add mod1 = Alt_L Meta_L
    ```
  - [Information on how xmodmap works](http://xahlee.info/linux/linux_xmodmap_tutorial.html)
  - Use `xmodmap ~/.Xmodmap` to source the changes.

> __Now, the Alt key on the left of the Spacebar functions as the left Ctrl key and will serve as Mac's Command key. And, the left Ctrl key functions as the left Alt key and will serve as Mac's Ctrl key__
  
- Next, open your terminal settings and change hotkeys for the commands that are "Ctrl+Shift+\*" to "Ctrl+\*" using the new Ctrl key. This would include copying, pasting, opening/closing a new tab/window, etc
- Finally, we will use the new Alt key to bring back all the "Ctrl+\*" functions that we overwrote in the previous step. However, it would not be possible to change hotkeys for every possible command in every other application. For example, my terminal doesn't allow to change hotkeys for commands like termination ("Ctrl+C") or EOF ("Ctrl+D"). Hence, we'll make use of AutoKey to map MacOS's Ctrl functions to Ubuntu's new Alt key. Open AutoKey and add the following phrases triggered via hotkeys with "terminator.Terminator" as a window filter
  - `Hotkey: <alt>+c --> <ctrl>+<alt>+c`. Since "Ctrl+C" was taken, the default terminating signal moved to "Ctrl+Alt+C"
  - `Hotkey: <alt>+d --> <ctrl>+d`
  - `Hotkey: <alt>+r --> <ctrl>+r`
  - `Hotkey: <alt>+w --> <ctrl>+w` & `Hotkey: <ctrl>+w --> <ctrl>+<shift>+w`. In this example, since I don't want to remap "Ctrl+W" function in Vim, I have to set the close-terminal hotkey in my terminal back to "Ctrl+Shift+W" and use AutoKey to send "Ctrl+Shift+W" when I press "Ctrl+W". This way I freed-up "Ctrl+W" for "Alt+W"
  - `Hotkey: <alt>+<tab> --> <ctrl>+<page_down>` (for chrome)
  - `Hotkey: <alt>+<shift>+<tab> --> <ctrl>+<page_up>` (for chrome)
- And that's it! This strategy could be used to get Mac keyboard layout for any application on Ubuntu

### **Map hjkl keys to arrow keys**
Once you go hjkl you can never go back. Vim users understand. Also given how everyone has clearly put their best people to make these arrow keys smaller and smaller, I am convinced they will eventually vanish. Plus, anything less than full-sized keyboard such as 60% keyboard would not have these arrow keys anyway. Give up the right Alt key to map "hjkl" to arrow keys,
  - Find the key encodings of the keys using `xmodmap -pke`. You can also use `xve` to find keycodes and keysymbols
  - Add the following to ~/.Xmodmap

    ```shell
    ! alt key -> Mode_switch
    keycode 108 = Mode_switch
    keycode 44 = j J Down
    keycode 45 = k K Up
    keycode 43 = h H Left
    keycode 46 = l L Right
    ```
  - This maps "Alt+j" to Down, "Alt+k" to Up and so on

### **Use capslock as escape**
Vim users are in for a treat with this one! Have you ever used the Capslock key since your inception into the world of capslocks? The only times it makes its presence in my life is when I am annoyed and about to type a password for the third time. Put it to work and enjoy another Esc key, much closer to your hand and heart.
- Append the following to ~/.Xmodmap

    ```shell
    ! set capslock to escape key
    clear Lock
    keycode 66 = Escape NoSymbol Escape
    ```

### **Touch-ups**
- In case you want to reset xmodmap mapping, run `setxkbmap -option`
- Finally, to autostart Xmodmap and AutoKey on login, make two `.desktop` applications in `~/.config/autostart/` that look like the following

  ```shell
  [Desktop Entry]
  Type=Application
  Terminal=false
  Name=Custom Key Mapping via Xmodmap
  Exec=/usr/bin/xmodmap /home/arpit/.Xmodmap
  Comment=
  Categories=GNOME;GTK;System;
  X-GNOME-Autostart-enabled=true
  ```

  ```shell
  [Desktop Entry]
  Type=Application
  Hidden=false
  NoDisplay=false
  Name=Autokey
  Exec=autokey-gtk &
  Comment=
  X-GNOME-Autostart-enabled=true
  ```

### **Permanent Keybindings**
For some weird reason xmodmap settings keep resetting, specially after plugging in a USB device. Below is the solution to permanently map our xmodmap keybindings.
- First step is to load our xmodmap mappings via `xmodmap ~/.Xmodmap` and then convert the mapping to an .xkb file via `xkbcomp $DISPLAY xkbmap`
- Now, all we have to do is find our xmodmap mappings in `xkbmap` and make those changes in system-wide map files in `/usr/share/X11/xkb/symbols`
- For the arrow keys, we need to update the file `inet` and insert the mappings show below (copied from `xkbmap`) inside `xkb_symbols "evdev"` block

  ```shell
    key <RALT> {
        type= "TWO_LEVEL",
        symbols[Group1]= [     Mode_switch,        NoSymbol ]
    };
    key <AC06> {
        type[group1]= "ALPHABETIC",
        symbols[Group1]= [               h,               H ],
        symbols[Group2]= [            Left ]
    };
    key <AC07> {
        type[group1]= "ALPHABETIC",
        symbols[Group1]= [               j,               J ],
        symbols[Group2]= [            Down ]
    };
    key <AC08> {
        type[group1]= "ALPHABETIC",
        symbols[Group1]= [               k,               K ],
        symbols[Group2]= [              Up ]
    };
    key <AC09> {
        type[group1]= "ALPHABETIC",
        symbols[Group1]= [               l,               L ],
        symbols[Group2]= [           Right ]
    };
  ```

- For swapping left Alt and Ctrl keys, we need to modify the file `pc` so that the final changes look like following:

  ```shell
    key <LCTL> {         [           Alt_L,          Meta_L ] };
    key <LALT> {         [       Control_L ] };
    modifier_map Mod1 { <LCTL> };
    modifier_map Control { <LALT> };
    modifier_map Control { <RCTL> };
    modifier_map Mod1 { <ALT> };
    modifier_map Mod1 { <META> };
    //include "altwin(meta_alt)"
  ```
- Finally, for setting the Capslock key to Escape key, modify the line that describes mapping for <CAPS> key in the same file `pc` so that it looks like `key <CAPS> { [ Escape ] };`
- Test the changes by resetting the current mapping via `setxkbmap -option`. If everything worked out, the keybindings would still exist!

## Keyboard Shortcuts
A couple of pseudo-Mac handy shortcuts that can be easily set in the keyboard settings. Note, if you have already swapped the left Ctrl key with the left Alt key, the below settings become more intuitive to set.

- To get back Mac's "Command+Spacebar" spotlight feature, set search to "Ctrl+Space"
- Launch web browser: Ctrl+Alt+W
- Launch home folder: Ctrl+Alt+H
- Switch applications: Ctrl+Tab
- Switch windows of an application: Ctrl+`
- Save a screenshot to Pictures: Shift+Ctrl+3  # Save a screenshot of the entire scren
- Save a screenshot of an area: Shift+Ctrl+4
- Record a short screencast: Shift+Ctrl+5
- Close window: Ctrl+Q

## Enable Quick-Preview macOS Style
- Insatll gnome-sushi: `sudo apt install gnome-sushi`
- Restart gnome: `nautilus -q`

## Touchpad Enhancements
If there is a reason why my next laptop could be a Macbook, it would be because of the touchpad. The touchpad experience on a Mac is lightyears ahead! No wonder the entire base is a giant touchpad on 16" Macbooks. Below are some changes to make Dell's touchpad suck less on Ubuntu.

### Disable single finger tap-and-drag
Every once in a while, single tap would be registered as double tap which will make the objects drag, making it very annoying. Disable it: `gsettings set org.gnome.desktop.peripherals.touchpad tap-and-drag false`

### Disable touchpad while typing
Another really annoying thing is the cursor jumping around when you are typing something. Thank me later and disable the touchpad while typing by doing the following:
- Install dconf-editor: `sudo apt install dconf-editor`
- Create a disable-while-typing key and set it to True: `dconf write org/gnome/desktop/peripherals/touchpad/disable-while-typing true`

### Enable Palm Detection
Apparently, disabling touchpad while typing is not enough to save you from infuriating cursor jumps while typing. So, we need to enable palm detection to disable palm touch.
- Add the line `Option "PalmDetection" "True"` in touchpad Section in the file `/usr/share/X11/xorg.conf.d/40-libinput.conf` after driver line.

### Enable touchpad gestures using libinput-gestures
- Add current user to the 'input' group: `sudo gpasswd -a $USER input`. This change takes affect only on the next log in.
- Install stuff: `sudjo apt-get install xdotool wmctrl; sudo apt-get install libinput-tools`
- Clone this forked repository instead of the original one: `git clone https://github.com/daveriedstra/libinput-gestures/tree/three-finger-drag`
- Compile and install: `cd libinput-gestures; sudo make install; sudo ./libinput-gestures-setup install`
- Copy sample conf file to home: `cp libinput-gestures.conf ~/.config/`
- Edit the file so that it has the following gestures on

  ```shell
  ##############################################################################
  # SWIPE GESTURES: adds four finger gestures I used to have on Mac
  ##############################################################################
  gesture swipe up 4      xdotool key super+s
  gesture swipe down 4    xdotool key super+s
  ##############################################################################
  # THREE-FINGER DRAG: one of my favourite Mac feature, tap-and-drag.
  # Although it's hackish, it works nonetheless
  ##############################################################################
  gesture swipebegin all 3 xdotool mousedown 1
  gesture swipeend all 3 xdotool mouseup 1
  gesture swipeupdate all 3 xdotool mousemove_relative -- x y
  ##############################################################################
  # PINCH GESTURES:
  ##############################################################################
  gesture pinch in 5     xdotool key super+a
  gesture pinch out 5    xdotool key super
  ```
- Autostart on login: `libinput-gestures-setup autostart`
- Start: `libinput-gestures-setup start`

## Better Terminal
- Install Terminator since it has a lot more features than the stock terminal: `sudo apt install terminator`
- Do the following changes in preferences:
  - Enable copy on highlight: Profiles -> General -> turn on "copy on selection"
  - Solarized theme: Profiles -> Colors -> Built-in-schemes -> Solarized dark
  - Set keybindings for closing and going to next or previous windows in the same way as Chrome

## Display Scale Settings

### a) Using experimental fractional scaling
- Enable fractional scaling in display settings:
`gsettings set org.gnome.mutter experimental-features "['x11-randr-fractional-scaling']"`  
- Set fractional scaling to 125% by navigating to settings -> devices -> displays on your Ubuntu
- Scale the text alone by 110% since 125% fractional scaling is still a little too small: `gsettings set org.gnome.desktop.interface text-scaling-factor 1.1`  
- In case you need to reset the settings, run this: `gsettings reset org.gnome.mutter experimental-features`  

### b) Without using experimental fractional scaling
- Since fractional scaling is still an experimental feature and makes my screen flick, I like scaling just the text: `gsettings set org.gnome.desktop.interface text-scaling-factor 1.375`

To autostart gsettings on login, make a .desktop application in ~/.config/autostart/ and add the code shown below. Make sure the Exec field contains the command you ran to fix your display.

```shell
[Desktop Entry]
Type=Application
Terminal=false
Name=Scale Text
Exec=/usr/bin/gsettings set org.gnome.desktop.interface text-scaling-factor 1.375
Comment=scales the text by 1.375
Categories=GNOME;GTK;System;
X-GNOME-Autostart-enabled=true
```

Also, after scaling the text, Universal Access menu icon on the top task bar would appear. In case you wanna get rid of it, install "Remove Accessibility" extension from Ubuntu Software Center.

## Turning Off Adaptive Brightness
Why? Why is that even a feature? Goodness gracious you could turn this pesky feature off otherwise this laptop was gonna fly back to where it came from. Restart and hold down F2 or F12 to enter BIOS settings. Go to Video and turn off EcoPower.

## Enable Web Whatsapp in Chromium
  - Copy the ".desktop" file to your local applications folder: `cp /var/lib/snapd/desktop/applications/chromium_chromium.desktop ~/.local/share/applications`
  - Insert this in the Exec command: `--user-agent='Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36'`

## Scale Spotify
- If installed through the Snap Store, copy the '.desktop' file to your local applications folder: `cp /var/lib/snapd/desktop/applications/spotify_spotify.desktop ~/.local/share/applications/`
- Insert this in the Exec command: `--force-device-scale-factor=1.375`

## Low Resolution Icon Fix in Application Switcher
- Insert this in the Exec commands of the applications that have low resolution icons during tab switch: `--class="<application>"`
- Applications installed via Snap Store would be in `/var/lib/snapd/desktop/applications/` otherwise they will be in `/usr/share/applications/`.

## Other Missing Enhancements
Following are some of the features that I like in macOS but don't have a way to get in Ubuntu. Please let me know in the comments below if you do.

- Better hibernation that doesn't drain as much battery
- Kinetic scrolling
- Cursor acceleration
- A system-wide two fingers pinch to zoom in and out

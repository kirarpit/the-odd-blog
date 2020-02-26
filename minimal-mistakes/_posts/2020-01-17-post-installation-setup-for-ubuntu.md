---
title: "Post-Installation Setup for Ubuntu 19.10 on Dell XPS 13 7390"
description: "Good-to-make improvements and enhancements for your freshly installed Ubuntu 19.10"
tags: [Ubuntu, Mac-to-Linux]
---
After being a macOS user since 2014, I recently switched to Ubuntu on my new Dell XPS. Here are some of the changes I had to make to ensure a smoother transition.

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
- Restart and hold down F2 or F12 to enter BIOS settings. Go to Video and turn off EcoPower

## Touchpad Enhancements

### Disable single finger tap-and-drag
- Every once in a while, single tap would be registered as double tap which will make the objects drag, making it very annoying. Disable it: `gsettings set org.gnome.desktop.peripherals.touchpad tap-and-drag false`

### Disable touchpad while typing
- Another quite annoying thing is cursor jumping around when you are typing something. Thank me later and disable the touchpad while typing by doing the following:
	- Install dconf-editor: `sudo apt install dconf-editor`
	- Create a disable-while-typing key and set it to True: `dconf write org/gnome/desktop/peripherals/touchpad/disable-while-typing true`

### Enable Palm Detection
- Apparently, disabling touchpad while typing is not enough to prevent you from infuriating cursor jumps while typing. So, we need to enable palm detection that would disable palm touch.
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


## Keyboard Macros via xmodmap
- Install it: `sudo apt install xkeycaps`
- Give up the right Alt key to map "hjkl" to arrow keys, Vim style:
  - Find the key encoding using `xmodmap -pke`
  - Add the following to ~/.Xmodmap

    ```shell
    ! CapsLock -> Mode_switch
    keycode 108 = Mode_switch
    keycode 44 = j J Down
    keycode 45 = k K Up
    keycode 43 = h H Left
    keycode 46 = l L Right
    ```

- Use `xmodmap ~/.Xmodmap` to activate
- To autostart macros on login, make a .desktop application in ~/.config/autostart/ and add the following

  ```shell
  [Desktop Entry]
  Type=Application
  Terminal=false
  Name=Map hjkl to Arrow Keys
  Exec=/usr/bin/xmodmap /home/arpit/.Xmodmap
  Comment=
  Categories=GNOME;GTK;System;
  X-GNOME-Autostart-enabled=true
  ```
- In case you want to reset the macros mapping: `setxkbmap -option`

## Enable Quick-Preview macOS Style
- Insatll gnome-sushi: `sudo apt install gnome-sushi`
- Restart gnome: `nautilus -q`

## Better Terminal
- Install Terminator since it has a lot more features than the stock terminal: `sudo apt install terminator`
- Do the following changes in preferences:
  - Enable copy on highlight: Profiles -> General -> turn on "copy on selection"
  - Solarized theme: Profiles -> Colors -> Built-in-schemes -> Solarized dark
  - Transparent background: Profile -> Background -> 99%
  - Set keybindings for closing and going to next or previous windows in the same way as Chrome

## Enable Web Whatsapp in Chromium
  - Copy the ".desktop" file to your local applications folder: `cp /var/lib/snapd/desktop/applications/chromium_chromium.desktop ~/.local/share/applications`
  - Insert this in the Exec command: `--user-agent='Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36'`

## Scale Spotify
- If installed through the Snap Store, copy the '.desktop' file to your local applications folder: `cp /var/lib/snapd/desktop/applications/spotify_spotify.desktop ~/.local/share/applications/`
- Insert this in the Exec command: `--force-device-scale-factor=1.375`

## Low Resolution Icon Fix in Application Switcher
- Insert this in the Exec commands of the applications that have low resolution icons during tab switch: `--class="<application>"`
- Applications installed via Snap Store would be in `/var/lib/snapd/desktop/applications/` otherwise they will be in `/usr/share/applications/`.

## Keyboard Shortcuts
A couple of pseudo-Mac handy shortcuts that can be easily set in the keyboard settings

- To get back Mac's "command + spacebar" feature for search: Super+Space
- Launch web browser: Ctrl+Alt+W
- Launch home folder: Ctrl+Alt+H
- Switch applications: Alt+Tab
- Save a screenshot of entire scren: Ctrl+Alt+3
- Save a screenshot of an area: Ctrl+Alt+4
- Record a screencast: Ctrl+Alt+5
- Close window: Ctrl+Q
- Maximize window: Ctrl+M
- Restore window: Ctrl+N

## Other Missing Enhancements
Following are some of the features that I like in macOS but don't have a way to get in Ubuntu. Please let me know in the comments below if you do.

- Kinetic Scrolling
- Cursor Acceleration
- A system-wide two fingers pinch to zoom in and out

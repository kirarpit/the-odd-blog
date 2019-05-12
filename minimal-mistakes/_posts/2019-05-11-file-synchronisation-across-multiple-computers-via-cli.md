---
title: "File Synchronisation Across Multiple Computers via CLI"
description: "File synchronisation between a local system and a remote server with Unison CLI"
tags: [file-sync, Unison, CLI]
---

These days, a lot of us have to deal with multiple computers a day. For example, I have a MacBook Pro where I do personal stuff and time to time some work related stuff too, and then I have a dedicated work desktop at my workplace.

A lot of times I find myself manually copying the changes I made on one computer to another by running `scp` commands. Even then, I have to be meticulous about not overwriting the new changes made on the destination system.

Hence, there is a necessity of automated synchronisation of files across multiple systems which detects the new changes made on one system and seamlessly propagate them to all the other systems. 

Arguably, one could simply use a dropbox folder but that's not an elegant solution, plus who wants to share their top secret data with Dropbox anyway.

[Unison](http://www.cis.upenn.edu/~bcpierce/unison/){:target="_blank"} is the tool we need that runs both on Unix and Windows, doesn't require sudo access on either of the machines and works between any pair of machines connected to the internet.

## Installing Unison
To install the program simply run `sudo apt-get -y install unison` on linux or `brew install unison` on Mac OS.

> Note, Unison version on both the systems - among which files are synchronised - need to be the same. To downgrade Unison to 2.48.4 on Mac OS follow [this](https://eric.blog/2019/01/12/install-unison-2-48-4-on-mac-os-x-with-homebrew/){:target="_blank"} guide.

## Running Unison
First, let's create two directories, "test1" and "test2" by running `mkdir test1 test2`. Next, we can synchronise these two directories simply by running `unison test1 test2`. Now, the next time we run the above command again, the changes made in either of the directories will be propagated to the other directory.

Similarly, files could be synchronised between a local machine and a remote server over SSH by running the following command.  
`unison test1 ssh://user@remotehost//home/ubuntu/test2`

We can also set a lot of options to configure synchronisation according to our needs, for example `-auto true` option automatically accepts default actions. A configuration file with `.prf` extension under `~/.unison/` directory will allow you to specify all these options in a file instead.

>Note, you might have to create the directory `~/.unison` in Mac OS if it doesn't get created automatically.

This is what my configuration file `~/.unison/my_conf.prf` looks like.

~~~~
# Roots of the synchronization
root = /Users/Arpit/
root = ssh://blog//home/kiralobo/

# Paths to synchronize
path = Desktop
path = Documents/shared

# Some regexps specifying names and paths to ignore
#ignore = Path stats    ## ignores /var/www/stats
#ignore = Path stats/*  ## ignores /var/www/stats/*
ignore = Name *DS_Store   ## ignores all files/directories that end with "DS_Store"

#          When set to true, this flag causes the user interface to skip
#          asking for confirmations on non-conflicting changes. (More
#          precisely, when the user interface is done setting the
#          propagation direction for one entry and is about to move to the
#          next, it will skip over all non-conflicting entries and go
#          directly to the next conflict.)
auto=true

#          When this is set to true, the user interface will ask no
#          questions at all. Non-conflicting changes will be propagated;
#          conflicts will be skipped.
batch=true

#          !When this is set to true, Unison will request an extra
#          confirmation if it appears that the entire replica has been
#          deleted, before propagating the change. If the batch flag is
#          also set, synchronization will be aborted. When the path
#          preference is used, the same confirmation will be requested for
#          top-level paths. (At the moment, this flag only affects the
#          text user interface.) See also the mountpoint preference.
confirmbigdel=true

#          When this preference is set to true, Unison will use the
#          modification time and length of a file as a `pseudo inode
#          number' when scanning replicas for updates, instead of reading
#          the full contents of every file. Under Windows, this may cause
#          Unison to miss propagating an update if the modification time
#          and length of the file are both unchanged by the update.
#          However, Unison will never overwrite such an update with a
#          change from the other replica, since it always does a safe
#          check for updates just before propagating a change. Thus, it is
#          reasonable to use this switch under Windows most of the time
#          and occasionally run Unison once with fastcheck set to false,
#          if you are worried that Unison may have overlooked an update.
#          The default value of the preference is auto, which causes
#          Unison to use fast checking on Unix replicas (where it is safe)
#          and slow checking on Windows replicas. For backward
#          compatibility, yes, no, and default can be used in place of
#          true, false, and auto. See the section "Fast Checking" for more
#          information.
fastcheck=true

#          When this flag is set to true, the group attributes of the
#          files are synchronized. Whether the group names or the group
#          identifiers are synchronizeddepends on the preference numerids.
group=false

#          When this flag is set to true, the owner attributes of the
#          files are synchronized. Whether the owner names or the owner
#          identifiers are synchronizeddepends on the preference
#          extttnumerids.
owner=false

#          Including the preference -prefer root causes Unison always to
#          resolve conflicts in favor of root, rather than asking for
#          guidance from the user. (The syntax of root is the same as for
#          the root preference, plus the special values newer and older.)
#          This preference is overridden by the preferpartial preference.
#          This preference should be used only if you are sure you know
#          what you are doing!
prefer=newer

#          When this preference is set to true, the textual user interface
#          will print nothing at all, except in the case of errors.
#          Setting silent to true automatically sets the batch preference
#          to true.
silent=true

#          When this flag is set to true, file modification times (but not
#          directory modtimes) are propagated.
times=true
~~~~

To use the above config file, simply run `unison my_conf`. Finally, a cron job could be set which runs the above command every 5 minutes or so.

## Discussion
With Unison the possibilities are endless. You could even synchronise arbitrary number of systems by making one system act as a central hub that sequentially runs multiple configuration files. Also, a lot of times, I run computationally expensive jobs on an HPC server which spit out a lot of data that I need to monitor on my local system at times. Unison makes it a lot easier than manually running scripts to transfer data. In short, Unison is a game changer!

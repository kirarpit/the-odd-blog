---
title: "Ethereum Mining in India"
description: "A guide to mine Ethereum in India 2017"
tags: [crypto, ethereum, mining, crypto-mining]
---

TL;DR: 
If you're only interested in checking out my mining rig’s configuration then refer the table below. It contains elaborated details of the components required to make the system and the prices at which I bought them in India. Or, if you're just interested to know whether it's still profitable to mine Ethereum in India then click [here](#nope).

[PCPartPicker Part List](https://in.pcpartpicker.com/list/hdH2vV){:target="_blank"} 

Type|Item|Price
:----|:----|:----
**CPU** | [Intel - Pentium G4560 3.5GHz Dual-Core Processor](https://in.pcpartpicker.com/product/8gKhP6/intel-pentium-g4560-35ghz-dual-core-processor-bx80677g4560){:target="_blank"} | ₹5,650.00 
**Motherboard** | [Asus - PRIME Z270-P ATX LGA1151 Motherboard](https://in.pcpartpicker.com/product/xwH48d/asus-prime-z270-p-atx-lga1151-motherboard-prime-z270-p){:target="_blank"} | ₹16,490.00 
**Memory** | [Kingston - HyperX Fury Black 8GB (1 x 8GB) DDR4-2133 Memory](https://in.pcpartpicker.com/product/8hM323/kingston-memory-hx421c14fb8){:target="_blank"} | ₹5,350.00 
**Storage** | [Western Digital - Green 120GB 2.5" Solid State Drive](https://in.pcpartpicker.com/product/2rYWGX/western-digital-green-120gb-25-solid-state-drive-wds120g1g0a){:target="_blank"} | ₹4,200.00 
**Video Card** | [Zotac - GeForce GTX 1060 6GB 6GB AMP! Edition Video Card **(X6)**](https://in.pcpartpicker.com/product/QVWrxr/zotac-geforce-gtx-1060-6gb-amp-edition-video-card-zt-p10600b-10m){:target="_blank"} | ₹1,51,200.00 
**Power Supply** | [Corsair - HX Platinum 750W 80+ Platinum Certified Fully-Modular ATX Power Supply **(X2)**](https://in.pcpartpicker.com/product/LkM323/corsair-hx-platinum-750w-80-platinum-certified-fully-modular-atx-power-supply-cp-9020137-na){:target="_blank"} | ₹27,400.00 
**Other**| Pack Of 6 Card Pci-E 16X To 1X Adapter Usb3.0 Usb 3.0 Riser Card Adapter Cable| ₹4,500.00 
 | *Prices include shipping, taxes, rebates, and discounts* |
 | **Total** | **₹2,14,790.00**

<figure class="third">
	<img src="/images/miner01.jpg" alt="miner_top_view">
	<img src="/images/miner02.jpg" alt="miner_side_view">
	<img src="/images/miner04.jpeg" alt="miner_top_front_view">
</figure>

## Whom is this guide for?
- If you're a crypto enthusiast and have been wondering about setting up your own mining rig but are uncertain of the logistics.
- If you wish, you knew a cool friend who’s already been mining so that you could gain some valuable insights before investing in it yourself.
- If you’ve already set up a mining rig but are facing difficulty in figuring out the optimal configuration of the system.

If you fall under any of the above defined categories then yes, this guide's for you.

## What questions are we gonna answer in this guide?
First of all, I'd strongly recommend to thoroughly go through [this guide](https://www.reddit.com/r/EtherMining/wiki/index){:target="_blank"} on reddit and subscribe to [EtherMining subreddit](https://www.reddit.com/r/EtherMining/){:target="_blank"} to stay updated about the latest tech revolving around Ethereum mining. The above guide extensively talks about the setting up part, so I'm gonna skip that. Although, there are a few things which need to be handled differently when done in India, we'll talk about them shortly.

In this guide we gonna majorly talk about post setting-up part like the best overclock configuration, best mining software, best pool to join and finally if it's still profitable and worth it to mine Ethereum.

## Some key points on Hardware
Getting hardware is indeed the hardest part because graphic cards(GPU) are not only way too expensive in India, the best ones like *Radeon RX* and *GIGABYTE* are not even readily available here. You might be able to get *GIGABYTE* online but they are way too overpriced. If you could hack this part and get cheap graphic cards somehow then that's half the battle won. So, if you have already made up your mind about setting up a rig, then devote 80% of your time in getting the right hardware.

On the contrary, I certainly didn't do much research in getting the right graphic cards and got myself *Zotac Amp Edition 1060 6GB* which gives around 22Mh/sec when overclocked. Not bad though. 1060s are supposed to give upto 24Mh/sec.

## Best Overclock Configuration
Key things to keep in mind when overclocking are Fan Speed, Memory Cycles and Power Usage.

- Fan speed plays a crucial role in maintaining the Card's temperature. In fact, even in summers, air conditioning is not required if the fan speed is set properly and good ventilation is maintained to avoid heat accumulation. Generally, fans work efficiently when set at 70-80% fan speed.
- Memory Cycles is the one which decides the hashrate output. More memory means better hashrate. But there is a limit upto which you could increase it without crashing your system. The cards are gonna be fine though as it's really difficult to brick a card, so feel free to try absurd settings.
- Increase in power usage after a limit wouldn't provide much improvements in hashrate and hence, wouldn't be worth increasing the electricity cost.
- Here's what my configuration looks like. I'm using [CycleNerd's Code](https://github.com/Cyclenerd/ethereum_nvidia_miner){:target="_blank"} for settings and setup files.
  
{% highlight ruby %}
   MY_WATT='80'
   MY_FAN='70'
   MY_MEM='1250'
   MY_CLOCK='-100'
{% endhighlight %}

- Despite of having a stable configuration, graphic cards tend to fail every now and then, which is why it’s crucial to have a system which automatically detects the outage and restarts the miner. Which brings us to our next question.

## Best Mining Software
[Claymore](https://github.com/nanopool/Claymore-Dual-Miner){:target="_blank"} is by far much better than any other available alternatives as of today. It provides much more flexibility in configuring the cards individually, generates much better reports, has inbuilt remote monitoring and Watchdog which automatically restarts the miner if a card fails. Although, it does charge 1% dev fee but with this level of reliability and quality, it's totally justified. Claymore also supports dual mining with a total dev fee of 2%. According to some people it's more profitable than Ethereum-only mining but I experience quite opposite.

On the other hand we have [Ethminer](https://github.com/ethereum-mining/ethminer){:target="_blank"}. Although it does have higher reported hashrate, I've never experienced better results, plus due to lack of Watchdog and remote monitoring it's unreliable. If some of these issues are addressed in new versions then Ethminer could compete with Claymore because it doesn't charge any dev fee.

## Best Mining Pool
There are a very few mining pools which don't have exorbitantly high latency when connected from India and [Dwarfpool](http://dwarfpool.com/eth){:target="_blank"} is one of them. The best configuration would be to connect to Asian Dwarfpool server on a stratum port. Other famous pools like [Nanopool](https://eth.nanopool.org/){:target="_blank"} and [Ethpool](https://ethermine.org/){:target="_blank"}, do provide better statistics and graphs but are useless for Indian miners as they have very high latency even when connected to their Asian counterparts. For reference, Dwarfpool's latency is around 80-100ms when compared to 300-800ms for other pools.

## Stats
The final command looks like this:  
`/usr/local/claymore73/ethdcrminer64 -epool "eth-asia.dwarfpool.com:8008" -ewal $MY_ADDRESS/$MY_RIG/$MY_EMAIL -epsw x -mode 1 -ftime 10 -mport 3333`

And here's what it produces, around 132Mh/s in total:
<figure>
	<img src="/images/claymore.png" alt="Claymore Report">
</figure>

The number of shares per hour on Dwarfpool with the above command looks like this:
<figure>
	<img src="/images/mining_shares.png" alt="Claymore Report">
</figure>

<a name="payout_screenshot"></a>
And finally these are the minimum payouts of 0.05 Ethers:
<figure>
	<img src="/images/mining_rewards.png" alt="Claymore Report">
</figure>

## <a name="nope"></a>Is it still worth mining Ethereum in India?
Short answer is nope. Long answer is that it depends on a lot of variables we discussed above and for most of the people who are yet to buy the hardware, the answer is still nope. The major reason is not the expensive hardware but increase in mining difficulty over the period of time.

If you take a closer look at the [payout screenshot](#payout_screenshot), you'll notice how it always took more time to get next payout than the time it took to get the previous one. It means that eventually with my current fixed hashrate, it will take me forever to get 0.05 Ether payout. According to [Ethereum Block Difficulty Growth chart](https://etherscan.io/chart/difficulty){:target="_blank"}, there was a 37% increase in difficutly from the months August to September and 43% from July to August. Although, it's an exponential curve but let's assume a constant increase of 25%(much lower than actual) in difficulty every month. According to my current payout, assuming I'm making 0.72 Ether per month as of now, the sum of my total future earnings could be defined by the following geometric progression.

```maths
S = 0.72 + 0.72*0.75 + 0.72*0.75^2 + 0.72*0.75^3 + ...

```
The sum of above GP is finite -- even if we extend the progression to infinity -- i.e. **2.88 Ethers**. Now, if I had directly purchased ethers with the money I spent on buying hardware, I'd have made around **10.33 Ethers** instantly. If you noticed, I haven't yet considered the electricity cost in running the hardware and mining is already 3.5 times less profitable than investing directly. Having said that, I could still make profit in terms of fiat currency, if in future the value of 2.88 Ethers becomes more than what I invested today, but it'd still always be a lot less than what 10.33 Ethers would have made.

To make things even worse, Ethereum community has long back decided to switch to Proof of Stake(POS) instead of Proof of Work(POW) which means Ethereum GPU mining would no longer be supported. To ensure that this updated release doesn't result into a split of the blockchain (AKA Hardfork), Ethereum mining bomb was deviced which will exponentially increase the difficulty upto such an extent that it'd literally take the total global hashpower years to mine a single block. Although POS implementation has been postponed to next year around December, the upcoming update would reduce the reward to 3 Ethers per block instead of 5 to compensate the delay.


## Conclusion
If you're a true believer of crypto currencies and want to hold them for a long time then investing directly and buying coins would definitely be much more profitable than mining of any sort. However, if mining as a concept fascinates you then it could very well be pursued as a hobby. You could closely follow and learn a lot about new upcoming blockchains, mine them and have a say in developing their future with your voting power. Not to mention, the immense amount of learning during the process of setting up a complete mining rig — which only depends on how much in depth you're willing to venture — is priceless.

> The capacity to learn is a gift; the ability to learn is a skill; the willingness to learn is a choice
>
~ Brian Herbert

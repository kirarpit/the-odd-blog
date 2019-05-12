---
title: "Solving Connect4 with Deep Reinforcement Learning(RL)"
description: "A Reinforcement Learning framework in python for board games like Connect4"
tags: [reinforcement-learning-algorithms, alphago-zero, connect4]
---

TL;DR: The code on Github can be found [here](https://github.com/kirarpit/connect4).

## About
As the title suggests, the post is about training a model using Deep RL which could play the game [Connect4](https://en.wikipedia.org/wiki/Connect_Four){:target="_blank"}. Before we dive into that, I wanna briefly talk about Deep RL to sorta give a very basic intuition about how the algorithm works. If you're interested in understanding Deep RL thoroughly, I suggest you to checkout [this series](https://jaromiru.com/2016/09/27/lets-make-a-dqn-theory/){:target="_blank"} of very well written posts.

## Deep Reinforcement Learning
Imagine there is a world and in this world there exists an agent. The agent knows nothing about how the world works. It has to interact with the world/environment to figure out how it works. What RL says is that add some randomness to your actions, try out new things, if the result exceeds your expectations then tune yourself in a way that you do this action more often in the future. And that's it!

How Deep RL is different than RL is that the agent here is an Artificial Neural Network(ANN). The basic intuition about how having an ANN changes everything is that it allows the agent to approximately solve an equation with hundreds and thousands of degrees of freedom, which otherwise would be nearly impossible to do.

Arguably, this algorithm works in a very similar way how humans learn. The generality of the algorithm makes it possible to apply it in many areas. Training a model to gain super human intelligence in [playing multiple Atari](https://www.cs.toronto.edu/~vmnih/docs/dqn.pdf){:target="_blank"} games with only one algorithm is one of the first successful examples which gained a lot of traction.

## Solving Connect4
Connect4 is a relatively simple game for computers to solve by doing an exhaustive tree search of all the possible future moves from a given board state. I anyway set out to build and train a model which could learn to play if not master it without using any human input.

For that, I implemented the two basic classes of RL algorithms i.e. Q-Learning and Policy Gradient, plus the relatively new self learning algorithm described in AlphaGo Zero paper by Google DeepMind. I've tried to write an exhaustive description of how my implementation of these algorithms in Python work along with the implementation and the results I obtained, [here](https://github.com/kirarpit/connect4){:target="_blank"}.

## Opinion
Another interesting topic of research in this area is to train a model which learns to learn aka Meta Learning. Overall, 
RL with deep neural nets does seem promising and is a step towards creating an Artificial General Intelligence(AGI). Although, there is no doubt that we are still [very very far](http://karpathy.github.io/2012/10/22/state-of-computer-vision/){:target="_blank"} from achieving that but given how rapid the progress in this field is and assuming the [Law of Accelerating Returns](http://www.kurzweilai.net/the-law-of-accelerating-returns){:target="_blank"} holds in the future, that might very well change soon, or at least I like to believe it so. :)

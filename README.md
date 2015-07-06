# Forgotten Story (Забытая История)

Included only for sole purpose of nostalgia. My first ever large project.

## Postmortem

During the development of this MMORPG for mobile phones, I came
close to making every wrong design decision possible, which is funny, since
the sole reason for me creating my own codebase was that the 
existing games from the PHP3 era were even worse.

The game featured almost every feature of other MMORPGs. There were your regular combat,
magic, trade (with NPCs and with other players). There were crafting and fishing,
hidden treasures, taming pets. The enemies leveled as they killed you,
and they had randimised skills to begin with. There were both mainline
"epic" quests and small side tasks. In short, the project was the
definition of a feature bloat.

Then there were original parts that made it fun. Your base chance to hit an
opponent was determined by a proportional equation, based on the relative
skill difference. This would be diminished by your health loss. 
However, your chance to make a critical hit would be increased with the loss 
of health. In effect, if you are about to die, you are unlikely to 
hit your opponent, but if you do, it will probably be a massive critical
hit, bringing your opponents health levels down to yours and making it a 50:50
once again. This was a random thought of mine, but it turned out to be 
a very engaging mechanic.

Another key feature that actually made it worth playing was random loot
from every NPC. Nothing new here, but my broken code would sometimes
drop Legendary Flambergs from your regular cellar rodents, which
hooked the newcomers for life. It has also contributed a great deal
to destroying the game balance.

The balance was completely killed with the introduction of teleport scrolls,
fire bombs that you could have thrown from a neighbouring location,
levitation spells, and ultra high-level boss mobs that, in theory,
could only be killed by team co-operation, and even then this would 
pose a great challenge. However, once you become a teleporting flying 
wizard that can set enemies on fire before they get a chance to get close...
You get an idea. Seems obvious in hindsight.

This, and the fact that I had no bank account at the age of 15 and 
hence relied on free hostings, where I would constantly exceed 
MySQL usage quotas, killed the project. However, the last nail to the
coffin was my realisation how terrible the code was and how much
effort would it take to fix it. I could rewrite from scratch the whole year-and-a-half
worth of effort in one month instead, I thought. Predictably, I never did.

On the bright side, this project was the reason why the University
made sense from the day 1 to me. I chose to study Software Engineering,
because I learned that even though I could write quicksort in 5 minutes
on a back of an envelope, give me anything that requires continuous effort
for a few months and I will turn it into a mess half way through. 

The years of grand eye-openings followed. MVC? The codebase would be
so much easier to understand... Third normal form? I could probably 
sustain my game on a free hosting... ORM? Heck, 2/3 of the whole 
codebase would go away! Learn to say no, build half a project,
not a half-assed project -- if only I stumbled upon *Getting Real* sooner.
Operand conditioning -- now I know why the reward system worked.

So here you have it. The code I am not proud of, but the effort I am.
I believe that every software engineer should start with a project like this.
Building something you really want to and failing at it because you
don't know how will keep you awake during otherwise painstakingly boring
UML lectures.


Vision
------
"My data is mine to mine" - Team Avengers

From the vision that data about you should be yours to control, instead of being stored on external, proprietary sites.
We came up with this idea very naturally, by following the following process:

Process
------
- We started out by getting to know each other a bit better
- Pretty soon we started talking about potential projects.
  We found a common foundation in a quote by Rasmus Lerdorf: "On your next project, try to add value to a person's life".
- Data ownership was a big "add value"-thing for us
- This can be a massive undertaking, so we started searching for an implementable example
- In our search, we came across medical data. Together with Jeremy's background, this seemed like a great prototype.
- This example allowed us to implement the 3 roles we envision: self, a 'pusher' and a 'puller'

Preparation + Technical stack
------
- On monday we ended with some raw persona's and an initial technical stack.
- On tuesday, we fleshed out the persona's, epics and stories
- After some initial research to validate our technical ideas, we drew some technical documentation
- We decided on a small technical stack, which grew on a need-to-have basis.
  We started out without any frameworks and only included Silex because it was small enough and got out of our way.

- PHP
- Git-Wrapper
- Composer
- PSR-0 + PSR-2
- Pimple
- Bootstrap
- jQuery
- Silex
- Symfony command?
- Twig

Scenario's and demo
------
- This is Douglas, he's a 26 year old tester at Rekall and is stressed out.
  (Show timeline, with just 1 bootstrap event)
- He went to the G.P., Bob
  (Hit first demo button)
- Bob suggested he should take a week off and come back in a month
- Douglas wasn't feeling much better, so he returned to Bob.
  (Hit the second demo button)
- Bob wrote our a prescription for some medicine
  (Hit the prescription button)
- Bob also referred Douglas to a specialist
  (Hit the specialist button)

Extra:
- Bob went to the pharmacist, Alice, to pick up his prescription
- Alice pulled the prescription from Douglas' data
  (Hit the pull button)
- Alice gave Douglas the medicine

Learnings
------
- The data itself was not discussed and drawn in the technical documentation. That cost us a lot of time later on, during the project
- At the end, we didn't go back to the board to create stories for new, lovable features. We got away with it and put some
  safety measures in place, but those parts are now the most risky and not everybody knows about how they work.
- We only added to the technical stack if we needed it, instead of bootstrapping a full-blown framework upfront.
  This prevented over engineering and saved us a lot of time.
- The preparations took us a bit longer that expected in the beginning, but saved us from a lot of overhead in the long run.
  We had a consistently high velocity because of it.

Conclusion
------
- A lot of examples came up, such as groceries, professional life, education, facebook, twitter.
- We see this project as a small piece in a much larger and broader vision. It can be made to contain a lot of personal data,
  which is then yours to decide about.
- This implementation is just a prototype, without any security features. Don't use it at home.
- We started with Rasmus' quote: "On your next project, try to add value to a person's life" and think that we did!

Questions
------

﻿<?php
  $spf['start'] = 'Добро пожаловать, усталый путник! Иди, присаживайся у камина, можешь съиграть вон с тем типом в кости. Да что ты, какой лохотрон, он простой парень, сам первый раз кости в руках держит. Кстате, а как съиграешь, может проголодаешся, так подходи, недорого подарю тебе еды да питья! Ну как, договорились?|sleep~да, все конечно класс, а ночлега непредоставишь усталому путнику?|learn~ну, вообще-то я не затем пришел. Мне сказали, что ты готовишь сам хорошо, так вот я так подумал...|girls~не уровень мне с типами в кости играть! Пиво чую есть, а девки где?';
  $spf['sleep'] = 'Неподумал как-то, но небоись, у нас тут тепло, все под столами у камина спят. А те кто на ногах стоит в ближайший дом спать идут. Вообшем спать есть где, расслабся, зачем утружнять себя тежелыми думами, лучше пивка купи...';
  $spf['learn'] = 'Ну? Что? Учить? ТЕБЯ то?! А может тебе еще ключ от комнаты, где деньги лежат, и дочь в приданное?!|doughter~нукась, а про дочь поподробнее...|learn_please~вот, уважаю таких людей, вы правидьно мыслите! Либо дочь, которая готовить умеет, либо учите, чтоб я сам как-нить...';
  if ($p['gender'] == 'male')
  {
    $spf['doughter'] = 'Ну и чтож я тебе, странник, про нее скажу? Взрослая уже, встретишь - сам с ней и беседуй...';
    $spf['girls'] = 'Ишь чего захотел, у нас приличное заведение! Впрочем, есть у меня... Ой, ладно, иши себе сам девок, походи по окрестностям, мот найдешь... А тогда иди прямо сюда, я и ей чего-нибудь дам недорого, пряник с ликером например...';
  }
  else
  {
    $spf['doughter'] = 'Тебе то она зачем? Непредставляю.Тебе надо - сама и ищи.';
    $spf['girls'] = 'Ну и девчата сейчас пошли, был бы я молодой... Девок то тебе зачем, парнейвокруг столько... Бестолковые, неслушают меня, свяжутся с вами, а их сразу к алтарю, и все, ни им в таверну сходить, ни пивка отпить - весь день гвозди в стены вкадачивают и унитазы ремонтируют, так как денег на сантехника жалко. Необращай внимания, на душе залежалось...';
  }
  $spf['learn_please'] = 'Ладно, непомешает тебе навык. Опыт придет со временем, но саму суть покажу. Для приготовления пиши нужен рецепт. Хотя можно и без него, но в нем все про все написано. Научу тебя пользоватся огнем, только это тебе обойдется в 700 монет.|learn_coo~давай!';
  if ($part == 'learn_coo')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (37, 700);
  }
?>
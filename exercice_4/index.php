<?php
spl_autoload_register(function($className){
    require_once realpath(__DIR__).'/class/'.$className.'.php';
});

// On instancie via le constructeur la classe Chat() afin de pouvoir afficher 3 chats différents
// et afficher le résultat à l’aide de la méthode g​etInfos()​
$chat_1 = new Chat('Penélope', 9, 'bleu', 'femelle', 'européen');
echo '<strong>Mon chat 1*</strong>';
echo '<ul>';
foreach($chat_1->getInfos() as $info){
	echo '<li>'.$info.'</li>';
}
echo '</ul>';

$chat_2 = new Chat('Elmo', 3, 'jaune', 'male', 'européen');
echo '<strong>Mon chat 2*</strong>';
echo '<ul>';
foreach($chat_2->getInfos() as $info){
	echo '<li>'.$info.'</li>';
}
echo '</ul>';

$chat_3 = new Chat('Estrella', 2, 'vert', 'male', 'européen');
echo '<strong>Mon chat 3*</strong>';
echo '<ul>';
foreach($chat_3->getInfos() as $info){
	echo '<li>'.$info.'</li>';
}
echo '</ul>';

echo '*: Toutes les informations concernant mes chats sont vérifiées. Seule leur couleur a été modifiée...';
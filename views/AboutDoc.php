<?php

require_once('BasicDoc.php');

class AboutDoc extends BasicDoc {
	protected function showHeader() {
        echo '    <h1>About Pagina</h1>' . PHP_EOL;
    }

    protected function showContent() {
        echo '    <p>Ik ben Thomas van Haastrecht, ik ben 26 jaar oud en woon in Haarlem. Ik heb in mijn jeugd veel gereisd vanwege mijn vaders werk. Ik heb 3 jaar in Duitsland gewoond, en  maarliefst 6 jaar in Ierland. Daarna zijn we weer terug verhuisd naar Nederland. Daar heb ik de middelbare school afgerond, en ik ben daarna naar Florida gegaan om Computer Science te studeren. Ik heb daar mijn bachelor gehaald en daarna tijdens de Coronaperiode een tijdje weer in Nederland gezeten. Ik ben later, eind 2021, weer terug naar Florida gegaan om mijn master te halen. Dat heb ik recent gedaan en ben nu sinds kort weer in Nederland.</p>
		<p>Ik ben verder een vrij rustig persoon, en hou wel van een beetje ontspanning. Hier zijn een aantal van mijn hobbies.</p>
		<ul>
			<li>Hockey</li>
			<li>Sudoku puzzels (en soortgelijke puzzels)</li>
			<li>Tijd doorbrengen met vrienden en familie</li>
			<li>Gamen</li>
			<li>Films en TV series kijken</li>
		</ul>' . PHP_EOL;
    }
}

?>
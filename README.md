# topheader
 Module for add a top header on Prestashop Store


Note :
Problème avec la db save sur la tab ps_configuration au lieu de ps_topheader
Après le save la data (1) save n'est pas récup et la page se refresh avec les anciennes infos (data 0).
Mais sur le front c'est ok.
Et si je fais une nouvelle save du backoffice c'est pas la data 0 mais la data 1 qui est affiché après le refresh

Initialisation chat :
Je développe un module pour Prestashop. Il a pour objectif d'afficher un top header sur le site et est paramétrable depuis le backoffice.


Je développe un module pour Prestashop. Il a pour objectif d'afficher un top header sur le site et est paramétrable depuis le backoffice. Je rencontre un problème avec les valeurs présentes dans la base de donnée et celle qui sont affichés sur le backoffice ou sur le front.
Dans le front le text affiché est bien celui de la db mais color et bg_color ne sont pas ceux de la db.
Pour le backoffice j'ai simplement un problème dans les données qui sont affichées. Quand on arrive sur la page ce n'est pas les données de la db qui sont affichées mais si modifient le text et les couleurs et que j'enregistre alors cela se met à jour dans la db mais au rechargement elles ne sont pas prises en compte. Pour debug cela j'ai voulu affiché directement sur ma page ce que je récupére de la db mais rien ne s'affiche.
Je t'ai donnée tous les fichiers pour que tu puisse mieux comprendre de quoi je parle et me proposer des corrections.
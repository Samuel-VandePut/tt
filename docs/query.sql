SELECT nom, prenom, classement, id_joueur
FROM rencontre
LEFT JOIN joueurs on rencontre.FK_joueur = joueurs.id_joueur
LEFT JOIN personnes on joueurs.FK_personne = personnes.id_personne
WHERE FK_Interclub = 4 AND FK_Equipe = 5





SELECT nom, prenom, classement, id_joueur
FROM joueurs
LEFT JOIN personnes on joueurs.FK_personne = personnes.id_personne



SELECT * 
FROM tt.match
LEFT JOIN rencontre on match.FK_rencontre = rencontre.id_rencontre
WHERE FK_Interclub = 5 AND FK_Equipe = 5

DELETE FROM `match` WHERE match.id_match between 211 and 226

SELECT * 
FROM tt.match
LEFT JOIN rencontre on match.FK_rencontre = rencontre.id_rencontre
LEFT JOIN interclub on rencontre.FK_Interclub = interclub.id_interclub
WHERE FK_Interclub = 5 AND FK_Equipe = 5 AND FK_joueur = 28


SELECT victoire,defaite
FROM tt.match
LEFT JOIN rencontre on match.FK_rencontre = rencontre.id_rencontre
WHERE FK_Joueur = 25
ORDER BY id_match DESC
LIMIT 5



SELECT FK_joueur
FROM rencontre
LEFT JOIN interclub on rencontre.FK_interclub = interclub.id_interclub
WHERE FK_Interclub = 5




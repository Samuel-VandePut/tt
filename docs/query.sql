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

DELETE FROM `match` WHERE match.id_match between 191 and 194
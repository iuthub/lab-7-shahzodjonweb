1) SELECT name FROM `movies` WHERE year=1995
2) SELECT COUNT(*) FROM `roles` WHERE movie_id=194874
3) SELECT first_name,last_name FROM `actors` WHERE id IN (SELECT actor_id FROM `roles` WHERE movie_id=194874)
4) SELECT first_name,last_name FROM `directors` WHERE id IN (SELECT director_id FROM `movies_directors` WHERE movie_id=112290)
5) SELECT COUNT(*) FROM `movies_directors` WHERE director_id=22104
6) SELECT first_name,last_name FROM `directors` WHERE id IN (SELECT director_id FROM `movies_directors` WHERE movie_id IN (SELECT movie_id FROM `movies_genres` WHERE genre="horror"))
7) SELECT first_name,last_name FROM actors WHERE id IN (SELECT actor_id FROM roles  WHERE movie_id IN (SELECT movie_id FROM `movies_directors` WHERE director_id=22104))
#Wild Blood

Simple API rest created for Halloween Hackathon at Wild Code School - Bordeaux

## available URLs 

###Hunters :
- [GET] list at [localhost:8000/hunter/all](localhost:8000/hunter/all) 
- [GET] list of hunters and monsters sorted by scores desc at [localhost:8000/hunter/rankingAll](localhost:8000/hunter/rankingAll) 
- [GET] infos on a hunter and its fights at [localhost:8000/hunter/show/:id](localhost:8000/hunter/show/2)
- [PUT] edit infos of a hunter at [localhost:8000/hunter/edit/:id](localhost:8000/hunter/edit/2)
- [POST] add a new hunter with infos at [localhost:8000/hunter/add](localhost:8000/hunter/add)
- [DELETE] delete a hunter at [localhost:8000/fight/hunter/:id](localhost:8000/hunter/delete/2) 

###Monsters :
- [GET] list at [localhost:8000/monster/all](localhost:8000/monster/all) 
- [GET] infos on a monster and its fights at [localhost:8000/monster/show/:id](localhost:8000/monster/show/2)
- [PUT] edit infos of a monster at [localhost:8000/monster/edit/:id](localhost:8000/monster/edit/2)
- [POST] add a new monster with infos at [localhost:8000/monster/add](localhost:8000/monster/add)
- [DELETE] delete a monster at [localhost:8000/fight/monster/:id](localhost:8000/monster/delete/2) 

###Fights :
- [GET] list at [localhost:8000/fight/all](localhost:8000/fight/all) 
- [GET] infos on a fight at [localhost:8000/fight/show/:id](localhost:8000/fight/show/2)
- [PUT] edit infos of a fight at [localhost:8000/fight/edit/:id](localhost:8000/fight/edit/2)
- [POST] add a new fight with infos at [localhost:8000/fight/add](localhost:8000/fight/add)
- [DELETE] delete a fight at [localhost:8000/fight/delete/:id](localhost:8000/fight/delete/2) 




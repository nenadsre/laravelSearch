# laravelSearch

##########################################################################

api  localhost:8080/api/add_file

method POST 

request 
{
    "name": "init.txt",
    "content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit", 
    "path" : "local/public"
}

response {"OK"}

##########################################################################

api localhost:8080/api/delete_file

method POST

request 
{
    "name": "init.txt",
    "path" : "local/public"
}

response {"OK"}

##########################################################################


api localhost:8080/api/search_file

method POST

request 
{
    "term": "txt"
}

response [
    "local/public/dva.txt",
    "local/public/test.txt",
    "local/public/telefon.txt",
    "local/public/flomaster.txt"
]


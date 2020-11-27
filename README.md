# ImmoEliza

Travail de groupe pour BeCode avec 3 Keller (Web dev) et un Turing (IA) :

- Keller:  **Dorian Storella**, **Gaetano Di Salvo**, **Olivia Fantinel**
- Turing:  **Joffrey Bienvenu**

Vous pouvez accédez au projet en cliquant [ici](https://immoeliza.herokuapp.com/).

## ImmoEmliza, c'est quoi ?

ImmoEliza est une application qui permet de récuperer une modélisation 3D approximative et une estimation de la valeur de n'importe quelle propriété en Wallonie (qui se trouve dans la base de données) en entrant le code postal, la rue et le numéro de maison.

À partir du formulaire, une requête est envoyée à une première API qui renvoie l'id de la maison à cette adresse. Cet id est ensuite envoyé en JS à une deuxième API qui renvoie les modèles 3D et d'autres informations.
*Note : Faire les deux requêtes en JS aurait été plus optimal, mais l'exercice obligeait d'introduire une requête en PHP, et recevoir les informations de la deuxième API était bien plus simple en JS.*

## Technologies utilisées

* **HTML/CSS/Bootstrap** - interface (Dorian Storella) ;
* **PHP** - requête à l'API pour trouver la maison à partir du formulaire (Gaetano Di Salvo) ;
* **JS/three.js** - requête à l'API des modèles 3D et visualisation 3D (Joffrey Bienvenu et Olivia Fantinel).

## Difficultés rencontrées 

Pour faire la première requête, le groupe avait d'abord utilisé cURL, une extension PHP. Un membre avait des problèmes et suspectait cURL d'en être la cause, et la première requête a donc été retravaillée pour être faite sans cURL.

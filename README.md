test project implementation

##### 1. [task definition](CigaretteMachine/README.md)

Tech stack:
* [PHP](<https://symfony.com/>) - popular general-purpose scripting language that is especially suited to web development
* [GIT](https://git-scm.com/) -  distributed version control system
* [DOCKER](https://www.docker.com/) - Docker makes development efficient and predictable

php libs:
* [MONEY](https://github.com/moneyphp/money)
* [BCMATH](https://www.php.net/manual/en/book.bc.php)


### Installation
* standard: 
  * install php 7.4 + composer locally:
  * Clone repo:
    ```sh
    $ git clone git@github.com:Michal-B-Rybczynski/limangoProject.git
    ```
  * Install dependencies:
    ```sh
    $ composer install
    ```
   * run app:
     ```sh
     php bin/console purchase-cigarettes 56 990.54
     ```
* via docker: 
  * install docker:
  * Clone repo:
    ```sh
    $ git clone git@github.com:Michal-B-Rybczynski/limangoProject.git
    ```
  * Create container:
    ```sh
    $ docker-compose up -d --build
    ```
    ![Alt text](img/Screenshot2.png?)
  * Get container id:
      ```sh
      $ docker ps
      ```
      ![Alt text](img/Screenshot3.png?)
  * go to created container:
    ```sh
    $ docker exec -it 15a8f2894c86 bash 
    ```
    ![Alt text](img/Screenshot4.png?)
  * launch project
    ```sh
    $ php bin/console purchase-cigarettes 56 990.54 
    ```
    ![Alt text](img/Screenshot1.png?)

# Github repository for Fort Hays State INF653
This repository contains completed assignments for FHSU INF653, completed by myself.

## Assignment-1
Contains PHP code challenges from lecture power points Fundamentals of the PHP language 1 and 2. These .php files contain the PHP code to complete the challenges, and import the boilerplate from the components folder to reduce code reuse.

## 03week
Contains the SQL Query Assignment from week 3. This assignment consists of creating an INNER JOIN query to retreive information from the [my_guitar_shop2 database](https://github.com/efuste/murachphp/blob/master/book_apps/_create_db/my_guitar_shop2.sql) and displays the result via index.php.

## 06week
Contains the Update Assignments and Courses in PHP and MySQL assignment from week 6. This assignment starts with the base PHP site from [the Instructor's github](https://github.com/ramseyFHSU/2025_Back-end_I/tree/main/Week%206) and adds the ability to update the information in an assignment and the name of a course. This assignment follows the MVC system for division of concerns.

# Notes

## Docker XAMPP database persistence
My original docker compose for the [tomsik68/xampp](https://hub.docker.com/r/tomsik68/xampp/) did not include a volume for the MySQL database data, and when I restarted the container, the database information was reset. The example docker compose file has been changed below to reflect this change. By ssh-ing into the container, the config files at /opt/lampp/etc and /opt/lampp/apache2/conf.d can now be updated and persist across container updates as well.

## Docker bind volume into htdocs folder
If the assignmentsProject folder where the code is located is bind mounted to the root of htdocs, then it covers up the existing PHP web interfaces located at the root. By moving the bind to htdocs/inf653 the pages remain available, and are reflected below.

## Environment
### PHP/MySQL
For the PHP/MySQL portion of this class, I am using docker on a linux server I run at my house to use the [tomsik68/xampp](https://hub.docker.com/r/tomsik68/xampp/) docker image of XAMPP. By setting a bind volume from my PHP workspace, which is on a samba share on the same server, to the /opt/lampp/htdocs folder I can edit the files and folders on my windows computer using VS Code, and then immediately see the results in a browser pointed to the ip address of the docker container. i.e. http://10.0.x.x/Assignment-1/challenge2-1.php

Docker Compose file:
````
services:
  xampp:
    image: tomsik68/xampp
    #ports: #container uses ssh for connections... 80 for http
    #    - 22:22
    #    - 80:80
    environment:
      - PUID=1000
      - PGID=1000
      - TZ=America/Chicago
    networks:
      dipv30:
        ipv4_address: 10.0.30.31
    volumes:
      - /store/Docs/School/Judson/FHSU/2025-1-Spring/INF653/assignmentsProject:/opt/lampp/htdocs/inf653
      - xamppApacheConf:/opt/lampp/apache2/conf.d
      - xamppEtc:/opt/lampp/etc
      - xamppMysqlData:/opt/lampp/var/mysql

volumes:
  xamppEtc:
  xamppMysqlData:
  xamppApacheConf:

networks:
  dipv30:
    external: true
````

### My docker config
My home setup has multiple vlans, one of which is specifically for untrusted docker containers, and all docker networking across all my containers are using layer 3 ipvlan drivers, connected to linux bridge with a virtual ethernet pair to add the correct vlan tags to the containers. All of that to say that each of my containers acts like another physical computer using docker host networking, i.e. I can point my browser to the ip address of the container and access all the ports in use, with no docker port forwarding. The bridge and veth pairs, combined with disabling docker's built in iptables firewall, ipforwarding, and default bridge means that I can access the containers by ip address, even from the host itself.

````
Diagram: [physical devices], (virtual devices), --- physical connection, *** virtual connection.

[network switch (access port) (trunk port)]---[(eth0)             server0           ]
                     |                        [   *                                 ]
                     |                        [ (bridge0)***(veth0p0)               ]
                     |                        [   *             *                   ]
                  [Laptop]                    [   *         (veth0p1)               ]
                                              [   *             *                   ]
                                              [   *   (docker ipvlan 30)****        ]
                                              [   *             *          *        ]
                                              [   *   (XAMPP container)    *        ]
                                              [   *                        *        ]
                                              [   *   (other containers on vlan 30) ]
                                              [   *                                 ]
                                              [ (veth1p0)***(veth1p1)               ]
                                              [               *                     ]
                                              [       (docker ipvlan 31)            ]
                                              [               *                     ]
                                              [   (other containers on vlan 31)     ]
````


docker daemon.json:
````
{
  "data-root": "/store/docker-data",
  "bridge": "none",
  "ip-forward": false,
  "iptables": false,
  "ip6tables": false,
  "dns": ["10.0.x.x"]
}
````
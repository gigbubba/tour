/*
  --- menu items --- 
  note that this structure has changed its format since previous version.
  additional third parameter is added for item scope settings.
  Now this structure is compatible with Tigra Menu GOLD.
  Format description can be found in product documentation.
*/
var MENU_ITEMS = [
   ['Member area', null, null,
      ['Security', null,null,
         ['Login', 'login.php' ],
         ['Logout', 'logout.php'],
         ['Change password', '???'],
      ],
      ['Your Matches', null,null,
         ['To play'  ],          // arrange date/date to play
         ['To report'],       // report score
      ],
      ['Your Events', 'events.php',null,
         ['Current'],
         ['Coming'],
         ['Past'],
      ],
   ],

   ['View', null, null,
     ['Tours', 'tours.php', null,
       ['All'            , 'tours.php',null],
       ['Singles Man A'  , 'tour.php?id=1',null],
       ['Singles Mixed A', 'tour.php?id=2',null],
     ],

     ['Events', 'events.php', null,
       ['All' , 'events.php',null],
       ['Coming', null ,null],
     ],

     ['Players', 'players.php', null,
       ['All'            , 'players.php',null],
     ]

   ], 


   ['Docs & Info', null, null,
      ['Tennis Code', 'info/code.html',null,
         ['Digest(pdf)', 'info/code_digest.pdf'],
      ],
      ['Tennis Rules(pdf)', 'info/rules.pdf',null,
         ['Digest', 'info/rules-brief.html'],
      ],
   ],
   ['Admin Area', null, null,
      ['Login', 'login.php'   ],
      ['Logout', 'logout.php' ],
      ['Events', 'events.php',null,
         ['New', 'do_event.php?action=new'],
      ],
      ['Players', 'players.php',null,
         ['New', 'do_player.php?action=new'],
      ],
      ['Tours', 'tours.php',null,
         ['New', 'do_tour.php?action=new'],
      ],
      ['Manage Users', 'do_users.php',null],
      ['Check DB Integrity', 'dbcheck.php',null],
      ['Todo', 'todo.php',null],
   ],
   ['Contact', null, null,
      ['E-mail', 'mailto:cyrilcanada@yahoo.com'],
   ],
];


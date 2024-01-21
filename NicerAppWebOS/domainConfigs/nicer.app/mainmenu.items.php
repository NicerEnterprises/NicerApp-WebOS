<?php 
    global $naWebOS;
    global $na_apps_structure;
    $na_apps_structure = array(
        "newsHeadlines_englishNews" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    'misc' => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    'apps' => [
                        'news' => [ // a more JSON and shorter way of declaring the leaf section of a tree-like JSON array.
                            'section' => 'English_News', // key pointing to value
                            'SEO_value' =>  'news' // same here
                        ]
                     ]
                ]
            ]
        ],
        "newsHeadlines_englishNews_worldHeadlines" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'news' => [ // a more JSON and shorter way of declaring a tree-like JSON array.
                            'section' => 'English_News__World_Headlines',
                            'SEO_value' => [ 'world-news', 'news-world', 'world-headlines', 'news-world-headlines' ]
                        ]
                     ]
                ]
            ]
        ],
        "newsHeadlines_englishNews_businessHeadlines" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'news' => [
                            'section' => 'English_News__Topics__Business',
                            'SEO_value' => [ 'nbh', 'news-business', 'business', 'business-news', 'news-business-headlines' ]
                        ]
                     ]
                ]
            ]
        ],
        "newsHeadlines_nederlandsNieuws" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'news' => [
                            'section' => 'Nederlands_Nieuws',
                            'SEO_value' => 'nieuws'
                        ]
                     ]
                ]
            ]
        ],
        "newsHeadlines_nederlandsNieuws_wereldNieuws" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'news' => [ 
                            'section' => 'Nederlands_Nieuws__Wereld',
                            'SEO_value' => 'nieuws-internationale-headlines'
                        ]
                     ]
                ]
            ]
        ],
        
        "newsHeadlines_deutscheNachrichten" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    'misc' => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    'apps' => [
                        'news' => [ 
                            'section' => 'Deutsche_nachrichten',
                            'SEO_value' => 'nachrichten'
                        ]
                     ]
                ]
            ]
        ],
        "newsHeadlines_arabic" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D',
                       'additionalCodeLocations' => [
                            'files' => [
                                '.../NicerAppWebOS/apps/NicerAppWebOS/applications/2D/news/class.newsApp-3.php' => [

                                ],
                                '.../NicerAppWebOS/apps/NicerAppWebOS/applications/2D/news/functions.php' => [

                                ]
                            ]
                       ]
                    ],
                    "apps" => [
                        'news' => [ 
                            'section' => 'Arabic',
                            'SEO_value' => 'Arabic-news-English'
                        ]
                     ]
                ]
            ]
        ],

        "wikipedia.org" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        '3rd-party-site.wikipedia.org' => [
                            'page' => 'index',
                            'SEO_value' => [ 'wiki', 'wikipedia', 'wikipedia.org' ]
                        ]
                     ]
                ]
            ]
        ],

        "tarot" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'cardgame.tarot' => [
                            'deck' => '/Waite-Smith/Pam Colman Smith/Original Rider Waite',
                            "reading" => "3-Cards",
                            'SEO_value' => [ 'tarot', 'cardgame-tarot' ]
                        ]
                     ]
                ]
            ]
        ],
        
        "music" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'musicPlayer' => [ 
                            'set' => 'index',
                            'SEO_value' => 'music'
                        ]
                     ]
                ]
            ]
        ],
        
        "music_index__Sabaton" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'musicPlayer' => [
                            'set' => 'Sabaton - Recent Hits (2022)',
                            'SEO_value' => 'music2022--bandName-Sabaton--album-mostRecentHits--originalCloudHosting-youtubeDotCom'
                        ]
                     ]
                ]
            ]
        ],

        "music_index__DJ_Firesnake" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'musicPlayer' => [ 
                            'set' => 'DJ_Firesnake',
                            'SEO_value' => [ 'music-djFireSnake', 'music2005-2012--artistName-djFireSnake--ownedBy-facebookDotCom-ReneVeermanDot90-aka-GavanHoverswell', 'music2005-2012--producerName-djFireSnake--ownedBy-facebookDotCom-ReneVeermanDot90-aka-GavanHoverswell' ]
                        ]
                     ]
                ]
            ]
        ],

        "music_index__DJ_Stiltje" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'musicPlayer' => [
                            'set' => 'DJ_Stiltje',
                            'SEO_value' => [ 'music-djStiltje' ]
                        ]
                     ]
                ]
            ]
        ],

        "music_index__Deep_House" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'musicPlayer' => [ 
                            'set' => 'Deep_House',
                            'SEO_value' => 'music2021--categoryName-deepHouse'
                        ]
                     ]
                ]
            ]
        ],


        "music_index__Arabic" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'musicPlayer' => [
                            'set' => 'Arabic_Tropical_Electronic_Downtempo',
                            'SEO_value' => [ 'music-arabic', 'music-Arabic' ]
                        ]
                     ]
                ]
            ]
        ],

        "music_index__Creedence" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'musicPlayer' => [
                            'set' => 'Creedence_Clearwater_Revival',
                            'SEO_value' => [ 'music-Creedence-Clearwater-Revival', 'music-creedence-clearwater-revival' ]
                        ]
                     ]
                ]
            ]
        ],

        "music_index__Early_21st_Century" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'musicPlayer' => [
                            'set' => 'Early_21st_Century',
                            'SEO_value' => [ 'music-Early-21st-Century', 'music-early-21st-century' ]
                        ]
                     ]
                ]
            ]
        ],

        "music_index__DBZ" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'musicPlayer' => [
                            'set' => 'DBZ_AMV_GMV_XXG',
                            'SEO_value' => [ 'music-DBZ-AMV-GMV-XXG', 'music-dbz-amv-gmv-xxg' ]
                        ]
                     ]
                ]
            ]
        ],

        "music_index__Beautiful_Chill_Mixes" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'musicPlayer' => [ 
                            "set" => "Beautiful_Chill_Mixes",
                            'SEO_value' => 'music2020--categoryName-beautifulChillMixes'
                        ]
                     ]
                ]
            ]
        ],
        
        "music_index__Black_Horse__Mongolian_Traditional_Classical_Music_Art" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'musicPlayer' => [
                            'set' => 'Black_Horse__Mongolian_Traditional_Classical_Music_Art',
                            'SEO_value' => 'music2005--bandName-Black_Horse--albumName-Mongolian-Traditional-Classical-Music-Art--note-containsOnlyTheAlbumsBestTracks'
                        ]
                     ]
                ]
            ]
        ],
        
        
        "analytics" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'analytics' => [
                            'SEO_value' => 'analytics'
                        ]
                     ]
                ]
            ]
        ],
        "3Dcube" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/3D'
                    ],
                    "apps" => [
                        'demo.3D.cube' => [
                            'parameters' => [],
                            'SEO_value' => 'demo-3D-cube'
                        ]
                     ]
                ]
            ]
        ],
        "3Dmodels" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/3D'
                    ],
                    "apps" => [
                        'demo.3D.modelLoading' => [
                            'parameters' => [],
                            'SEO_value' => 'demo-3D-models'
                        ]
                     ]
                ]
            ]
        ],
        "backgroundsBrowser" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/3D'
                    ],
                    "apps" => [
                        'app.3D.fileExplorer' => [
                            'parameters' => [
                                'thumbnails' => './thumbs/300/$filename.$ext'
                            ],
                            'SEO_value' => [ 'demo-3D-fileBrowser', '3D-data' ]
                        ]
                     ]
                ]
            ]
        ],
        
        "cms" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS'
                    ],
                    "apps" => [
                        'meta' => [
                            'mustBeLoggedIn' => true
                        ],
                        'blogEditor' => [
                            'page' => 'index',
                            'SEO_value' => [ 'me' ]
                        ]
                     ]
                ]
            ]
        ],

        "ugm" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS'
                    ],
                    "apps" => [
                        'meta' => [
                            'mustBeLoggedIn' => true
                        ],
                        'cmsManager' => [
                            'page' => 'index',
                            'SEO_value' => [ 'cms', 'ugm', 'ug', 'users', 'users-groups', 'usersGroups' ]
                        ]
                     ]
                ]
            ]
        ],

        "docs__overview" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    'misc' => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS'
                    ],
                    "apps" => [
                        'diskText' => [
                            'file' => '/NicerAppWebOS/documentation/NicerApp-WebOS--overview.php',
                            'title' => '/NicerAppWebOS/documentation/NicerApp-WebOS--overview.title.php',
                            'SEO_value' =>  [ 'docs', 'docs-overview' ]
                        ]
                     ]
                ]
            ]
        ],

        "docs__license" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    'misc' => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS'
                    ],
                    "apps" => [
                        'diskText' => [
                            'file' => '/NicerAppWebOS/LICENSE.php',
                            'title' => '/NicerAppWebOS/LICENSE.title.php',
                            'SEO_value' =>  [ 'license', 'LICENSE', 'docs-license' ]
                        ]
                     ]
                ]
            ]
        ],
        "docs__todoList" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    'misc' => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS'
                    ],
                    "apps" => [
                        'diskText' => [
                            'file' => '/NicerAppWebOS/documentation/NicerApp-WebOS--todoList--v5.y.z.php',
                            'title' => '/NicerAppWebOS/documentation/NicerApp-WebOS--todoList.title.php',
                            'SEO_value' =>  [ 'todo', 'docs-todoList' ]
                        ]
                     ]
                ]
            ]
        ],

        "docs__companyOverview" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    'misc' => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS'
                    ],
                    "apps" => [
                        'diskText' => [
                            'file' => '/NicerAppWebOS/documentation/NicerEnterprises--company.php',
                            'title' => '/NicerAppWebOS/documentation/NicerEnterprises--company.title.php',
                            'SEO_value' =>  'company'
                        ]
                     ]
                ]
            ]
        ],

        "tasks" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/application-programmer-interfaces/tasks'
                    ],
                    "apps" => [
                        'meta' => [
                            'mustBeLoggedIn' => true
                        ],
                        'manager' => [
                            'page' => 'index',
                            'SEO_value' => 'tasksManager'
                        ]
                     ]
                ]
            ]
        ],
        
        "webmail" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'meta' => [
                            'mustBeLoggedIn' => true
                        ],
                        'webmail' => [
                            'page' => 'index',
                            'SEO_value' => 'mail'
                        ] 
                     ]
                ]
            ]
        ],
        
        "forums__view_index" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'meta' => [
                            'mustBeLoggedIn' => true
                        ],
                        'forums__view_index' => [
                            'page' => 'index',
                            'SEO_value' => 'forums-configuration'
                        ] 
                     ]
                ]
            ]
        ],
        
        
        "jsonViewer" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/ui'
                    ],
                    "apps" => [
                        'meta' => [
                            'mustBeLoggedIn' => true
                        ],
                        'jsonViewer' => [
                            'page' => 'index',
                            'SEO_value' => [ 'jv', 'jsonViewer' ]
                        ]
                     ]
                ]
            ]
        ],

        "logs" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'meta' => [
                            'mustBeLoggedIn' => true
                        ],
                        'logs' => [
                            'page' => 'index',
                            'SEO_value' => 'logs'
                        ]
                     ]
                ]
            ]
        ]


        
     );
             
				
global $naURLs;
$naURLs = array();
foreach ($na_apps_structure as $pageID => $pageStructure) {
foreach ($pageStructure as $viewKeyID => $viewKeySettings) {
foreach ($viewKeySettings as $softwareKey => $softwareKeySettings) {
foreach ($softwareKeySettings as $softKey => $softSettings) {

    if ($softKey==='misc') {
        $folder = $softSettings['folder'];
    }
    if ($softKey==='apps') {
    
        foreach ($softSettings as $viewFolderName => $viewSettings) {
        
            if (array_key_exists('SEO_value', $viewSettings)) {
                    if (is_array($viewSettings['SEO_value'])) {
                        foreach ($viewSettings['SEO_value'] as $seovIdx => $seoValue) {
                            $url = '/'.$seoValue;
                            $json = json_encode ($viewSettings);
                            $naURLs[$pageID] = $url; // will get modified into /apps-content/.* links by .../.htaccess and fed from that .htaccess to .../ajax_get_content.php 
                            break;
                        }
                    } else {
                        $url = '/'.$viewSettings['SEO_value'];
                        $json = json_encode ($softwareKeySettings['apps']);
                        $naURLs[$pageID] = $url;
                    }
            } else {
                if (false) {
                    echo '<pre style="color:red">';
                    echo $folder.PHP_EOL;
                    var_dump ($softwareKeySettings);
                    echo '</pre>';
                }
                $naURLs[$pageID] = '/apps/'.base64_encode_url(json_encode($softwareKeySettings['apps'])); // will get modified into /apps-content/.* links by na.site.transformLinks() in JS.
            }
        }
    }

                   
}
}
}
}  
?>

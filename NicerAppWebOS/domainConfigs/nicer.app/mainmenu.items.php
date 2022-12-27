<?php 
    global $naWebOS;
    global $na_apps_structure;
    $na_apps_structure = array( // the PHP variable name $na_apps_structure is the point where the trunk of the tree goes either into the air, or the ground (as the root-kit system or spyware application.
        // NicerAppWebOS version 5.0.0 (aka : THIS FILE IS FULLY FINALIZED. FOR NOW. FOR AT LEAST THE NEXT 5 YEARS OR SO. ) :
        "diskText__GPH_politicalContributions_2020s" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    'misc' => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerApp-WCS'
                    ],
                    "apps" => [
                        'diskText' => [ // a more JSON and shorter way of declaring the leaf section of a tree-like JSON array.
                            'file' => 'user--Rene_AJM_Veerman-aka-Gavan_Peacefan_Hoverswell/app.dialog.siteContent-politicalContributions.php', // key pointing to value
                            'SEO_value' =>  'political-ideas--Gavan-Peacefan-Hoverswell' // same here
                        ]
                     ]
                ]
            ]
        ],
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
                            'SEO_value' => [ 'world-news', 'news-world', 'news-world-headlines' ]
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
        
        "tarot" => [
            'apps-current' => [
                'NicerApp-WebOS__pageSettings' => [
                    "misc" => [
                       'folder' => '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D'
                    ],
                    "apps" => [
                        'cardgame.tarot' => [ 
                            'deck' => 'Original Rider Waite',
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
                        'analytics' => [] 
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
                                'thumbnails' => './thumbs/$filename.$ext'
                            ],
                            'SEO_value' => 'demo-3D-fileBrowser'
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
                            'SEO_value' => [ 'cms', 'me' ]
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
                            'SEO_value' => [ 'cms', 'me' ]
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
                            'SEO_value' => [ 'cms', 'me' ]
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
                            'SEO_value' =>  'docs-overview'
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
                            'SEO_value' =>  'docs-license'
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
                            'file' => '/NicerAppWebOS/documentation/NicerApp-WebOS--todoList.php',
                            'SEO_value' =>  'docs-todoList'
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

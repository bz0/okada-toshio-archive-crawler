<?php
    namespace OkadaToshioArchiveCrawler\Crawler;
    
    class SiteConfig{
        const DOMAIN = "epbot.site";

        const NICONAMA = [
            "content-type" => "json",
            "path"  => "/api/nicotext",
            "params" => [
                "both" => "false",
                "orderBy" => 1,
                "checkedCategories" => 2012
            ],
            "contents" => [
                "records" => [
                    "title",
                    "slug"
                ]
            ],
            "func" => ""
        ];

        const WEBCOLUMN = [
            "content-type" => "json",
            "path" => "/api/lecturetext",
            "params" => [
                "both" => "false",
                "orderBy" => 1,
                "checkedCategories[]" => "対談,ひとり夜話,2020,2019,2018,2017,2016,2015,2014,2013,2012,2011,2010,2009"
            ],
            "contents" => [
                "records" => [
                    "title",
                    "slug"
                ]
            ]
        ];
    }
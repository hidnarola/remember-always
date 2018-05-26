<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <?php
        $description = $this->meta_description;
        $keyword = $this->meta_keyword;
        $meta_title = $this->meta_title;
        $og_title = $this->meta_title;
        $og_image = (isset($og_image)) ? $og_image : '';
        $og_description = $this->meta_description;
        ?>
        <meta name="title" content="<?php echo $meta_title ?>">
        <meta name="keyword" content="<?php echo $keyword ?>">
        <meta name="description" content="<?php echo $description ?>">
        <meta property="og:url" content="<?php echo site_url(uri_string()); ?>"/>
        <meta property="og:title" content="Remember Always | <?php echo $og_title; ?>"/>
        <?php if (isset($og_image)) { ?>
            <meta property="og:image" content="<?php echo $og_image ?>"/>
        <?php } ?>
        <meta property="og:description" content="<?php echo $og_description ?>"/>
        <meta property="og:type" content="website"/>

        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo $title; ?></title>

        <!-- Bootstrap -->
        <!--<link href="https://fonts.googleapis.com/css?family=Oswald:300,700|Roboto:400,500|Rubik:300,400,500,700,900" rel="stylesheet">-->
        <style type="text/css">
            /* cyrillic */
            @font-face {
                font-family: 'Oswald';
                font-style: normal;
                font-weight: 300;
                src: local('Oswald Light'), local('Oswald-Light'), url(https://fonts.gstatic.com/s/oswald/v16/TK3hWkUHHAIjg75-sh0Tvs9CE5Q.woff2) format('woff2');
                unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* vietnamese */
            @font-face {
                font-family: 'Oswald';
                font-style: normal;
                font-weight: 300;
                src: local('Oswald Light'), local('Oswald-Light'), url(https://fonts.gstatic.com/s/oswald/v16/TK3hWkUHHAIjg75-sh0Ttc9CE5Q.woff2) format('woff2');
                unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
            }
            /* latin-ext */
            @font-face {
                font-family: 'Oswald';
                font-style: normal;
                font-weight: 300;
                src: local('Oswald Light'), local('Oswald-Light'), url(https://fonts.gstatic.com/s/oswald/v16/TK3hWkUHHAIjg75-sh0TtM9CE5Q.woff2) format('woff2');
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Oswald';
                font-style: normal;
                font-weight: 300;
                src: local('Oswald Light'), local('Oswald-Light'), url(https://fonts.gstatic.com/s/oswald/v16/TK3hWkUHHAIjg75-sh0Tus9C.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic */
            @font-face {
                font-family: 'Oswald';
                font-style: normal;
                font-weight: 700;
                src: local('Oswald Bold'), local('Oswald-Bold'), url(https://fonts.gstatic.com/s/oswald/v16/TK3hWkUHHAIjg75-ohoTvs9CE5Q.woff2) format('woff2');
                unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* vietnamese */
            @font-face {
                font-family: 'Oswald';
                font-style: normal;
                font-weight: 700;
                src: local('Oswald Bold'), local('Oswald-Bold'), url(https://fonts.gstatic.com/s/oswald/v16/TK3hWkUHHAIjg75-ohoTtc9CE5Q.woff2) format('woff2');
                unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
            }
            /* latin-ext */
            @font-face {
                font-family: 'Oswald';
                font-style: normal;
                font-weight: 700;
                src: local('Oswald Bold'), local('Oswald-Bold'), url(https://fonts.gstatic.com/s/oswald/v16/TK3hWkUHHAIjg75-ohoTtM9CE5Q.woff2) format('woff2');
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Oswald';
                font-style: normal;
                font-weight: 700;
                src: local('Oswald Bold'), local('Oswald-Bold'), url(https://fonts.gstatic.com/s/oswald/v16/TK3hWkUHHAIjg75-ohoTus9C.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic-ext */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 400;
                src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu72xKOzY.woff2) format('woff2');
                unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
            }
            /* cyrillic */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 400;
                src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu5mxKOzY.woff2) format('woff2');
                unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* greek-ext */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 400;
                src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu7mxKOzY.woff2) format('woff2');
                unicode-range: U+1F00-1FFF;
            }
            /* greek */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 400;
                src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu4WxKOzY.woff2) format('woff2');
                unicode-range: U+0370-03FF;
            }
            /* vietnamese */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 400;
                src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu7WxKOzY.woff2) format('woff2');
                unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
            }
            /* latin-ext */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 400;
                src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu7GxKOzY.woff2) format('woff2');
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 400;
                src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu4mxK.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic-ext */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 500;
                src: local('Roboto Medium'), local('Roboto-Medium'), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmEU9fCRc4EsA.woff2) format('woff2');
                unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
            }
            /* cyrillic */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 500;
                src: local('Roboto Medium'), local('Roboto-Medium'), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmEU9fABc4EsA.woff2) format('woff2');
                unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* greek-ext */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 500;
                src: local('Roboto Medium'), local('Roboto-Medium'), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmEU9fCBc4EsA.woff2) format('woff2');
                unicode-range: U+1F00-1FFF;
            }
            /* greek */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 500;
                src: local('Roboto Medium'), local('Roboto-Medium'), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmEU9fBxc4EsA.woff2) format('woff2');
                unicode-range: U+0370-03FF;
            }
            /* vietnamese */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 500;
                src: local('Roboto Medium'), local('Roboto-Medium'), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmEU9fCxc4EsA.woff2) format('woff2');
                unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
            }
            /* latin-ext */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 500;
                src: local('Roboto Medium'), local('Roboto-Medium'), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmEU9fChc4EsA.woff2) format('woff2');
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 500;
                src: local('Roboto Medium'), local('Roboto-Medium'), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmEU9fBBc4.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 300;
                src: local('Rubik Light'), local('Rubik-Light'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7Fqj2mZ8WDm7Q.woff2) format('woff2');
                unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* hebrew */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 300;
                src: local('Rubik Light'), local('Rubik-Light'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7Fqj2mf8WDm7Q.woff2) format('woff2');
                unicode-range: U+0590-05FF, U+20AA, U+25CC, U+FB1D-FB4F;
            }
            /* latin-ext */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 300;
                src: local('Rubik Light'), local('Rubik-Light'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7Fqj2mT8WDm7Q.woff2) format('woff2');
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 300;
                src: local('Rubik Light'), local('Rubik-Light'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7Fqj2md8WA.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 400;
                src: local('Rubik'), local('Rubik-Regular'), url(https://fonts.gstatic.com/s/rubik/v7/iJWKBXyIfDnIV7nFrXyi0A.woff2) format('woff2');
                unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* hebrew */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 400;
                src: local('Rubik'), local('Rubik-Regular'), url(https://fonts.gstatic.com/s/rubik/v7/iJWKBXyIfDnIV7nDrXyi0A.woff2) format('woff2');
                unicode-range: U+0590-05FF, U+20AA, U+25CC, U+FB1D-FB4F;
            }
            /* latin-ext */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 400;
                src: local('Rubik'), local('Rubik-Regular'), url(https://fonts.gstatic.com/s/rubik/v7/iJWKBXyIfDnIV7nPrXyi0A.woff2) format('woff2');
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 400;
                src: local('Rubik'), local('Rubik-Regular'), url(https://fonts.gstatic.com/s/rubik/v7/iJWKBXyIfDnIV7nBrXw.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 500;
                src: local('Rubik Medium'), local('Rubik-Medium'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7EyjmmZ8WDm7Q.woff2) format('woff2');
                unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* hebrew */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 500;
                src: local('Rubik Medium'), local('Rubik-Medium'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7Eyjmmf8WDm7Q.woff2) format('woff2');
                unicode-range: U+0590-05FF, U+20AA, U+25CC, U+FB1D-FB4F;
            }
            /* latin-ext */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 500;
                src: local('Rubik Medium'), local('Rubik-Medium'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7EyjmmT8WDm7Q.woff2) format('woff2');
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 500;
                src: local('Rubik Medium'), local('Rubik-Medium'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7Eyjmmd8WA.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 700;
                src: local('Rubik Bold'), local('Rubik-Bold'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7F6iGmZ8WDm7Q.woff2) format('woff2');
                unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* hebrew */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 700;
                src: local('Rubik Bold'), local('Rubik-Bold'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7F6iGmf8WDm7Q.woff2) format('woff2');
                unicode-range: U+0590-05FF, U+20AA, U+25CC, U+FB1D-FB4F;
            }
            /* latin-ext */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 700;
                src: local('Rubik Bold'), local('Rubik-Bold'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7F6iGmT8WDm7Q.woff2) format('woff2');
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 700;
                src: local('Rubik Bold'), local('Rubik-Bold'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7F6iGmd8WA.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 900;
                src: local('Rubik Black'), local('Rubik-Black'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7FCimmZ8WDm7Q.woff2) format('woff2');
                unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* hebrew */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 900;
                src: local('Rubik Black'), local('Rubik-Black'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7FCimmf8WDm7Q.woff2) format('woff2');
                unicode-range: U+0590-05FF, U+20AA, U+25CC, U+FB1D-FB4F;
            }
            /* latin-ext */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 900;
                src: local('Rubik Black'), local('Rubik-Black'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7FCimmT8WDm7Q.woff2) format('woff2');
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Rubik';
                font-style: normal;
                font-weight: 900;
                src: local('Rubik Black'), local('Rubik-Black'), url(https://fonts.gstatic.com/s/rubik/v7/iJWHBXyIfDnIV7FCimmd8WA.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
        </style>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"  rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-114429616-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'UA-114429616-1');
            gtag('config', 'AW-973112771');
        </script>
        <?php if ($this->controller == 'profile' && $this->action == 'share') { ?>
            <!-- Event snippet for Profile Completion - Signup conversion page --> 
            <script> gtag('event', 'conversion', {'send_to': 'AW-973112771/waM5CIm07YABEMOLgtAD'});</script> 
        <?php } ?>

        <base href="<?php echo base_url(); ?>">

        <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>" >
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/bootstrap-select.min.css" rel="stylesheet">
        <link href="assets/css/owl.carousel.css" rel="stylesheet" />
        <link href="assets/css/jquery.mCustomScrollbar.min.css" rel="stylesheet" />
        <link href="assets/css/sweetalert2.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/responsive.css" rel="stylesheet" />
        <link href="assets/css/developer.css" rel="stylesheet" />
        <link href="assets/css/responsive.css" rel="stylesheet" />
        <link href="assets/css/pnotify.custom.min.css" rel="stylesheet" />
        <link href="assets/css/jquery.fancybox.css" rel="stylesheet" />
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />-->
        <link href="assets/css/magnific-popup.css" rel="stylesheet" />

        <script type="text/javascript">
            //Set common javascript variable
            var site_url = "<?php echo site_url() ?>";
            var google_map_key = "<?php echo GOOGLE_MAP_KEY ?>";
            var base_url = "<?php echo base_url() ?>";
            var current_dir = '<?php echo $this->router->fetch_directory() ?>';
            var s_msg = "<?php echo $this->session->flashdata('success') ?>";
            var e_msg = "<?php echo $this->session->flashdata('error') ?>";
            var reset_pwd = 0;
            var max_image_size = <?php echo MAX_IMAGE_SIZE ?>;
            var max_video_size = <?php echo MAX_VIDEO_SIZE ?>;
            var max_images_count = <?php echo MAX_IMAGES_COUNT ?>;
            var max_videos_count = <?php echo MAX_VIDEOS_COUNT ?>;
        </script>
        <?php if (isset($reset_password)) { ?>
            <script>reset_pwd = 1;</script>
        <?php } ?>
        <noscript>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=js_disabled">
        </noscript>    

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/bootstrap-select.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/jquery.validate.min.js"></script>
        <script src="assets/js/additional-methods.min.js"></script>
        <script src="assets/js/pnotify.custom.min.js"></script> 
        <script src="assets/js/jquery.fancybox.js"></script>
        <script src="assets/js/jquery.fancybox.pack.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>-->

        <script src="assets/js/sweetalert2.all.min.js"></script>
        <script src="assets/js/jquery.mCustomScrollbar.js"></script>
        <script src="assets/js/typeahead.bundle.js"></script>
        <script src="assets/js/jquery.creditCardValidator.js"></script> 
        <script src="assets/js/responsive-tabs.js"></script>  
        <script src="assets/js/jquery.magnific-popup.min.js"></script>  
        <script src="assets/js/exif.js"></script>
        <script src="assets/js/custom.js"></script> 
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <?php
    $body_class = '';
    if ($this->controller != 'home' && $this->controller != 'login') {
        $body_class = 'inr-pages';
    }
    ?>
    <body class="<?php echo $body_class ?>">
        <div class="loader" style="display:none">
            <!--<img src="assets/images/loader.svg" />-->
            <svg class="lds-microsoft" width="80px"  height="80px"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" style="background: none;"><g transform="rotate(0)"><circle cx="73.801" cy="68.263" fill="#fff" r="3" transform="rotate(19.9989 50 50)">
            <animateTransform attributeName="transform" type="rotate" calcMode="spline" values="0 50 50;360 50 50" times="0;1" keySplines="0.5 0 0.5 1" repeatCount="indefinite" dur="1.5s" begin="0s"></animateTransform>
            </circle><circle cx="68.263" cy="73.801" fill="#fff" r="3" transform="rotate(31.0642 50 50)">
            <animateTransform attributeName="transform" type="rotate" calcMode="spline" values="0 50 50;360 50 50" times="0;1" keySplines="0.5 0 0.5 1" repeatCount="indefinite" dur="1.5s" begin="-0.062s"></animateTransform>
            </circle><circle cx="61.481" cy="77.716" fill="#fff" r="3" transform="rotate(45.4963 50 50)">
            <animateTransform attributeName="transform" type="rotate" calcMode="spline" values="0 50 50;360 50 50" times="0;1" keySplines="0.5 0 0.5 1" repeatCount="indefinite" dur="1.5s" begin="-0.125s"></animateTransform>
            </circle><circle cx="53.916" cy="79.743" fill="#fff" r="3" transform="rotate(63.1103 50 50)">
            <animateTransform attributeName="transform" type="rotate" calcMode="spline" values="0 50 50;360 50 50" times="0;1" keySplines="0.5 0 0.5 1" repeatCount="indefinite" dur="1.5s" begin="-0.187s"></animateTransform>
            </circle><circle cx="46.084" cy="79.743" fill="#fff" r="3" transform="rotate(84.5772 50 50)">
            <animateTransform attributeName="transform" type="rotate" calcMode="spline" values="0 50 50;360 50 50" times="0;1" keySplines="0.5 0 0.5 1" repeatCount="indefinite" dur="1.5s" begin="-0.25s"></animateTransform>
            </circle><circle cx="38.519" cy="77.716" fill="#fff" r="3" transform="rotate(109.033 50 50)">
            <animateTransform attributeName="transform" type="rotate" calcMode="spline" values="0 50 50;360 50 50" times="0;1" keySplines="0.5 0 0.5 1" repeatCount="indefinite" dur="1.5s" begin="-0.312s"></animateTransform>
            </circle><circle cx="31.737" cy="73.801" fill="#fff" r="3" transform="rotate(136.705 50 50)">
            <animateTransform attributeName="transform" type="rotate" calcMode="spline" values="0 50 50;360 50 50" times="0;1" keySplines="0.5 0 0.5 1" repeatCount="indefinite" dur="1.5s" begin="-0.375s"></animateTransform>
            </circle><circle cx="26.199" cy="68.263" fill="#fff" r="3" transform="rotate(165.784 50 50)">
            <animateTransform attributeName="transform" type="rotate" calcMode="spline" values="0 50 50;360 50 50" times="0;1" keySplines="0.5 0 0.5 1" repeatCount="indefinite" dur="1.5s" begin="-0.437s"></animateTransform>
            </circle><animateTransform attributeName="transform" type="rotate" calcMode="spline" values="0 50 50;0 50 50" times="0;1" keySplines="0.5 0 0.5 1" repeatCount="indefinite" dur="1.5s"></animateTransform></g></svg>
        </div>
        <?php
        $this->load->view('Templates/default_header');
        echo $body;
        $this->load->view('Templates/default_footer');
        ?>
        <div class="custom_pop mfp-hide white-popup-block" id="login">
            <div class="login-signup">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#log-in" aria-controls="home" role="tab" data-toggle="tab">Log IN</a></li>
                    <li role="presentation"><a href="#sign-up" aria-controls="profile" role="tab" data-toggle="tab">Sign up</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="log-in">
                        <form method="post" id="login-form" action="<?php echo site_url('login') ?>">
                            <div class="login-options">
                                <a href="<?php echo site_url('facebook') ?>"><img src="assets/images/facebook-login.png" alt="" /></a>
                                <a href="<?php echo site_url('google') ?>"><img src="assets/images/google-login.png" alt="" /></a>
                            </div>
                            <div class="popup-or">
                                <span>OR</span>
                            </div>
                            <div class="popup-input">
                                <label>Email</label>
                                <input type="text" name="email" id="loginpop_email" placeholder="support@gmail.com" />
                            </div>
                            <div class="popup-input">
                                <label>Password</label>
                                <input type="password" name="password" id="loginpop_password"  placeholder="password" />
                            </div>
                            <div class="keep-me">
                                <label class="custom-checkbox">keep me signed in
                                    <input type="checkbox" name="remember_me" value="1">
                                    <span class="checkmark"></span>
                                </label>
                                <a href="javascript:void(0)" onclick="showForgotModal()">Forget your password?</a>
                            </div>
                            <div class="pup-btn">
                                <button type="submit" id="login_form_btn">LOG IN</button>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="sign-up">
                        <form method="post" id="signup-form" action="<?php echo site_url('signup') ?>">
                            <div class="login-options">
                                <a href="<?php echo site_url('facebook') ?>"><img src="assets/images/facebook-login.png" alt="" /></a>
                                <a href="<?php echo site_url('google') ?>"><img src="assets/images/google-login.png" alt="" /></a>
                            </div>
                            <div class="popup-or">
                                <span>OR</span>
                            </div>
                            <div class="popup-input">
                                <label>Email</label>
                                <input type="text" name="email" placeholder="support@gmail.com" />
                            </div>
                            <div class="popup-input">
                                <label>Password</label>
                                <input type="password" name="password" id="password" placeholder="Password" />
                            </div>
                            <div class="popup-input">
                                <label>Confirm Password</label>
                                <input type="password" name="con_password" placeholder="Confirm password" />
                            </div>
                            <div class="popup-input name-input">
                                <label>Name</label>
                                <div class="first-last">
                                    <input type="text" name="firstname" placeholder="First Name" />
                                </div>
                                <div class="last-first">
                                    <input type="text" name="lastname" placeholder="Last Name" />
                                </div>
                            </div>
                            <div class="keep-me">
                                <label class="custom-checkbox"><a href="<?php echo site_url('pages/terms-of-service') ?>">I agree to Terms of Service</a>
                                    <input type="checkbox" name="terms_condition" value="1">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="pup-btn">
                                <button type="submit" id="signup_form_btn">Sign UP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="forgot-pwdmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="login-signup">
                    <div class="mpopup-header">
                        Password recovery
                    </div>
                    <div class="mpopup-body">
                        <form method="post" id="forgot_password_form" action="<?php echo site_url('forgot_password') ?>">
                            <div class="popup-input">
                                <label>Email</label>
                                <input type="text" name="email" id="email" placeholder="Your email" />
                            </div>
                            <div class="keep-me">
                                <a href="javascript:void(0)" onclick="loginforgetModal()">Back to login?</a>
                            </div>
                            <div class="pup-btn">
                                <button type="submit" id="reset_password_btn">RESET PASSWORD</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="resetpwd-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="login-signup">
                    <div class="mpopup-header">
                        Change Password
                    </div>
                    <div class="mpopup-body">
                        <?php
                        $reset_pwd_code = '';
                        if (isset($reset_password_code)) {
                            $reset_pwd_code = $reset_password_code;
                        }
                        ?>
                        <form method="post" id="reset_password_form" action="<?php echo site_url('reset_password?code=' . $reset_pwd_code) ?>">
                            <div class="popup-input">
                                <label>Password</label>
                                <input type="password" name="password" id="reset_password" placeholder="Password" />
                            </div>
                            <div class="popup-input">
                                <label>Confirm Password</label>
                                <input type="password" name="con_password" id="con_password" placeholder="Confirm Password" />
                            </div>
                            <div class="keep-me">
                                <a href="javascript:void(0)" onclick="loginrestModal()">Back to login?</a>
                            </div>
                            <div class="pup-btn">
                                <button type="submit" id="change_password_btn">CHANGE PASSWORD</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade post-modal" id="post-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="login-signup">
                    <div class="mpopup-body">
                        <p>Post is Empty. Please enter post comment or select image or video file for post.</p>
                        <button type="button" onclick="$('#post-modal').modal('toggle')" class="fa fa-close"></button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
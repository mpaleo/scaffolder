<!DOCTYPE html>
<html>
<head>
    <title>Laravel scaffolder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- jQuery --}}
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    {{-- Material icons --}}
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Materialize --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>

    <style>
        body,
        html {
            background : #E7E7E7;
        }

        body {
            display        : flex;
            min-height     : 100vh;
            flex-direction : column;
        }

        main {
            flex       : 1 0 auto;
            margin-top : -190px;
        }

        .brand-logo {
            font-size : 20px !important;
        }

        .ribbon {
            width               : 100%;
            height              : 40vh;
            -webkit-flex-shrink : 0;
            -ms-flex-negative   : 0;
            flex-shrink         : 0;
        }

        .field-separator {
            background-color : #E7E7E7;
            height           : 2px;
        }

        .add-field-fab,
        .remove-model-fab {
            position : absolute;
            left     : -7px;
        }

        .add-field-fab {
            top : 17px;
        }

        .remove-model-fab {
            top : 60px;
        }

        .remove-field-fab {
            position : absolute;
            left     : 20px;
            display  : none;
        }

        .fields > div:hover .remove-field-fab {
            display : block;
        }

        #models-collection > div > div {
            position : relative;
        }

        .table-of-contents {
            background-color : #fff;
            padding-right    : 15px;
            border-radius    : 2px;
        }

        .table-of-contents a.active {
            border-left-color : #d81b60 !important;
            color             : #ea4a4f;
            font-weight       : 300;
        }

        asside.pin-top {
            position   : fixed;
            top        : 45% !important;
            transition : .3s all ease;
        }

        asside.pinned {
            transition : .3s all ease;
        }

        asside.pinned .table-of-contents {
            margin-top : 0;
        }

        .fields > div {
            border-radius : 2px;
            padding       : 10px 10px 25px;
            transition    : all .4s ease;
        }

        .fields > div:hover {
            background-color : #FFF !important;
            transition       : all .3s ease;
        }

        .fields > div {
            background : #F5F5F5;
        }

        ::selection {
            background : rgba(253, 223, 131, 0.6);
        }

        ::-moz-selection {
            background : rgba(253, 223, 131, 0.6);
        }

        {{-- Typeahead --}}
        .tt-menu {
            border-radius    : 2px;
            box-shadow       : 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            left             : 10px !important;
            background-color : #fff;
            padding          : 10px
        }

        @media only screen and (max-width : 992px) {
            main {
                margin-top : -210px;
            }
        }

        @media only screen and (min-width : 992px) {
            .brand-logo {
                margin-left : 20px;
            }
        }
    </style>
</head>
<body>

    {{-- Nav --}}
    <nav>
        <div class="nav-wrapper teal darken-2">
            <a href="#" class="brand-logo">Laravel scaffolder</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a class="waves-effect" href="https://github.com/mPaleo/scaffolder" target="_blank">GitHub</a></li>
                <li><a class="waves-effect" href="https://github.com/mPaleo/scaffolder/wiki" target="_blank">Wiki</a>
                </li>
                <li><a class="waves-effect" href="https://github.com/mPaleo/scaffolder/issues" target="_blank">Help</a>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Ribbon --}}
    <div class="ribbon teal"></div>

    {{-- Main content --}}
    <main>
        <form>
            <div class="row">
                <div class="col l6 s10 offset-l3 offset-s1">
                    <div class="card-panel">

                        {{-- Application settings --}}
                        <div id="application-settings-section" class="section scrollspy">
                            <h5>Application settings</h5>

                            {{-- Application name --}}
                            <div class="row">
                                <div class="input-field col m12 s12">
                                    <input id="name" name="name" type="text" class="validate">
                                    <label for="name">Application name</label>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        {{-- User interface --}}
                        <div id="user-interface-section" class="section scrollspy">
                            <h5>User interface</h5>

                            <div class="row">
                                <div class="input-field col m12 s12">
                                    <input id="pageTitle" name="userInterface[pageTitle]" type="text"
                                           class="validate">
                                    <label for="pageTitle">Page title</label>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        {{-- Paths --}}
                        <div id="paths-section" class="section scrollspy">
                            <h5>Paths</h5>

                            <div class="row">
                                <div class="input-field col m6 s12">
                                    <input id="migrationsPath" name="paths[migrations]" type="text" class="validate"
                                           value="base:database/migrations/">
                                    <label for="migrationsPath">Migrations</label>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input id="modelsPath" name="paths[models]" type="text" class="validate"
                                           value="app:Models/">
                                    <label for="modelsPath">Models</label>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input id="repositoriesPath" name="paths[repositories]" type="text"
                                           class="validate"
                                           value="app:Libraries/Repositories/">
                                    <label for="repositoriesPath">Repositories</label>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input id="controllersPath" name="paths[controllers]" type="text"
                                           class="validate"
                                           value="app:Http/Controllers/">
                                    <label for="controllersPath">Controllers</label>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input id="viewsPath" name="paths[views]" type="text" class="validate"
                                           value="base:resources/views/">
                                    <label for="viewsPath">Views</label>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input id="assetsPath" name="paths[assets]" type="text" class="validate"
                                           value="base:public/">
                                    <label for="assetsPath">Assets</label>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input id="routesPath" name="paths[routes]" type="text" class="validate"
                                           value="app:Http/routes.php">
                                    <label for="routesPath">Routes</label>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        {{-- Namespaces --}}
                        <div id="namespaces-section" class="section scrollspy">
                            <h5>Namespaces</h5>

                            <div class="row">
                                <div class="input-field col m12 s12">
                                    <input id="modelsNamespace" name="namespaces[models]" type="text"
                                           class="validate"
                                           value="App\Models">
                                    <label for="modelsNamespace">Models</label>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input id="repositoriesNamespace" name="namespaces[repositories]" type="text"
                                           class="validate" value="App\Libraries\Repositories">
                                    <label for="repositoriesNamespace">Repositories</label>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input id="controllersNamespace" name="namespaces[controllers]" type="text"
                                           class="validate" value="App\Http\Controllers">
                                    <label for="controllersNamespace">Controllers</label>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        {{-- Inheritances --}}
                        <div id="inheritances-section" class="section scrollspy">
                            <h5>Inheritances</h5>

                            <div class="row">
                                <div class="input-field col m6 s12">
                                    <input id="controllerInheritance" name="inheritance[controller]" type="text"
                                           class="validate" value="Scaffolder\Controller\AppBaseController">
                                    <label for="controllerInheritance">Controller</label>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input id="modelInheritance" name="inheritance[model]" type="text"
                                           class="validate"
                                           value="Illuminate\Database\Eloquent\Model">
                                    <label for="modelInheritance">Model</label>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        {{-- Routing --}}
                        <div id="routing-section" class="section scrollspy">
                            <h5>Routing</h5>

                            <div class="row">
                                <div class="input-field col m12 s12">
                                    <input id="routingPrefix" name="routing[prefix]" type="text"
                                           class="validate" value="scaffolder">
                                    <label for="routingPrefix">Prefix</label>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        {{-- API --}}
                        <div id="api-section" class="section scrollspy">
                            <h5>API</h5>

                            <div class="row">
                                <div class="input-field col m12 s12">
                                    <input id="apiDomain" name="api[domain]" type="text"
                                           class="validate" value="api.app.domain">
                                    <label for="apiDomain">Domain</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col l6 s10 offset-l3 offset-s1">
                    <div class="card-panel">

                        {{-- Theme extensions --}}
                        <div id="theme-extensions-section" class="section center-align scrollspy">
                            <h5>Theme extensions</h5>
                        </div>

                        @if(!empty(ViewTags::taggedWith('scaffolder.theme.extension')))
                            @foreach (ViewTags::taggedWith('scaffolder.theme.extension') as $extensionView)
                                @include($extensionView)
                            @endforeach
                        @else
                            <p class="center-align">There are no extension views to load</p>
                        @endif
                    </div>
                </div>

                <div class="col l6 s10 offset-l3 offset-s1">
                    <div class="card-panel">

                        {{-- Extensions --}}
                        <div id="extensions-section" class="section center-align scrollspy">
                            <h5>Extensions</h5>
                        </div>

                        @if(!empty(ViewTags::taggedWith('scaffolder.extension')))
                            @foreach (ViewTags::taggedWith('scaffolder.extension') as $extensionView)
                                @include($extensionView)
                            @endforeach
                        @else
                            <p class="center-align">There are no extension views to load</p>
                        @endif
                    </div>
                </div>

                <div class="col l6 s10 offset-l3 offset-s1">
                    <div class="card-panel">

                        {{-- Model generation --}}
                        <div id="model-generation-section" class="section center-align scrollspy">
                            <h5>Model generation</h5>
                        </div>
                    </div>
                </div>

                <div id="models-collection">

                    <div id="modelId-0">
                        <div class="col l6 s10 offset-l3 offset-s1">

                            {{-- Add field FAB --}}
                            <a onclick="$.addField(0)"
                               class="btn-floating waves-effect waves-light pink darken-1 add-field-fab"
                               data-delay="0">
                                <i class="material-icons">add</i>
                            </a>

                            {{-- Remove model FAB --}}
                            <a onclick="$.removeModel(0)"
                               class="btn-floating waves-effect waves-light pink darken-1 remove-model-fab"
                               data-delay="0">
                                <i class="material-icons">remove</i>
                            </a>

                            <div class="card-panel">
                                <div class="section">
                                    <div class="row">
                                        <div class="row">

                                            {{-- Model name--}}
                                            <div class="input-field col m4 s12">
                                                <input id="modelName-0" name="models[0][modelName]" type="text"
                                                       class="validate">
                                                <label for="modelName-0">Model name</label>
                                            </div>

                                            {{-- Model label --}}
                                            <div class="input-field col m4 s12">
                                                <input id="modelLabel-0" name="models[0][modelLabel]" type="text"
                                                       class="validate">
                                                <label for="modelLabel-0">Model label</label>
                                            </div>

                                            {{-- Table name --}}
                                            <div class="input-field col m4 s12">
                                                <input id="tableName-0" name="models[0][tableName]" type="text"
                                                       class="validate">
                                                <label for="tableName-0">Table name</label>
                                            </div>

                                            {{-- Skip migration --}}
                                            <div class="input-field col m3 s6">
                                                <input type="hidden" name="models[0][skipMigration]"
                                                       value="false"/>
                                                <input type="checkbox" id="skipMigration-0"
                                                       name="models[0][skipMigration]" value="true"/>
                                                <label for="skipMigration-0">Skip migration</label>
                                            </div>

                                            {{-- Skip model --}}
                                            <div class="input-field col m3 s6">
                                                <input type="hidden" name="models[0][skipModel]"
                                                       value="false"/>
                                                <input type="checkbox" id="skipModel-0"
                                                       name="models[0][skipModel]" value="true"/>
                                                <label for="skipModel-0">Skip model</label>
                                            </div>

                                            {{-- Skip controller --}}
                                            <div class="input-field col m3 s6">
                                                <input type="hidden" name="models[0][skipController]"
                                                       value="false"/>
                                                <input type="checkbox" id="skipController-0"
                                                       name="models[0][skipController]" value="true"/>
                                                <label for="skipController-0">Skip controller</label>
                                            </div>

                                            {{-- Skip views --}}
                                            <div class="input-field col m3 s6">
                                                <input type="hidden" name="models[0][skipViews]"
                                                       value="false"/>
                                                <input type="checkbox" id="skipViews-0"
                                                       name="models[0][skipViews]" value="true"/>
                                                <label for="skipViews-0">Skip views</label>
                                            </div>
                                        </div>

                                        <div class="fields col s12">

                                            <div id="field-0-0" class="row z-depth-1">

                                                {{-- Remove field FAB --}}
                                                <a onclick="$.removeField(0, 0)"
                                                   class="btn-floating waves-effect waves-light pink darken-1 remove-field-fab"
                                                   data-delay="0">
                                                    <i class="material-icons">remove</i>
                                                </a>

                                                {{-- Field name --}}
                                                <div class="input-field col m6 s12">
                                                    <input id="fieldName-0-0" name="models[0][fields][0][name]"
                                                           type="text"
                                                           class="validate typeahead">
                                                    <label for="fieldName-0-0">Field name</label>
                                                </div>

                                                {{-- Validations --}}
                                                <div class="input-field col m6 s12">
                                                    <input id="validations-0-0" name="models[0][fields][0][validations]"
                                                           type="text"
                                                           class="validate typeahead">
                                                    <label for="validations-0-0">Validations</label>
                                                </div>

                                                {{-- Database type --}}
                                                <div class="input-field col m6 s12">
                                                    <input id="databaseType-0-0" name="models[0][fields][0][type][db]"
                                                           type="text"
                                                           class="validate typeahead">
                                                    <label for="databaseType-0-0">Database type</label>
                                                </div>

                                                {{-- UI type --}}
                                                <div class="input-field col m6 s12">
                                                    <input id="uiType-0-0" name="models[0][fields][0][type][ui]"
                                                           type="text"
                                                           class="validate typeahead">
                                                    <label for="uiType-0-0">UI type</label>
                                                </div>

                                                {{-- Modifiers --}}
                                                <div class="input-field col m12 s12">
                                                    <input id="modifiers-0-0" name="models[0][fields][0][modifiers]"
                                                           type="text"
                                                           class="validate typeahead"
                                                           placeholder="e.g. modifier_1:modifier_2">
                                                    <label for="modifiers-0-0">Modifiers</label>
                                                </div>

                                                {{-- Foreign key --}}
                                                <div class="input-field col m12 s12">
                                                    <input id="foreignKey-0-0" name="models[0][fields][0][foreignKey]"
                                                           type="text"
                                                           class="validate typeahead"
                                                           placeholder="field:table:referential option">
                                                    <label for="foreignKey-0-0">Foreign key</label>
                                                </div>

                                                <div class="input-field col m12 s12">
                                                    <h6 class="center-align">Index types</h6>
                                                </div>

                                                {{-- No index --}}
                                                <div class="input-field col m3 s6">
                                                    <input class="with-gap" name="models[0][fields][0][index]"
                                                           type="radio"
                                                           id="none-0-0" value="none" checked>
                                                    <label for="none-0-0">None</label>
                                                </div>

                                                {{-- Primary key --}}
                                                <div class="input-field col m3 s6">
                                                    <input class="with-gap" name="models[0][fields][0][index]"
                                                           type="radio"
                                                           id="primaryKey-0-0" value="primary"/>
                                                    <label for="primaryKey-0-0">Primary</label>
                                                </div>

                                                {{-- Unique --}}
                                                <div class="input-field col m3 s6">
                                                    <input class="with-gap" name="models[0][fields][0][index]"
                                                           type="radio"
                                                           id="unique-0-0" value="unique"/>
                                                    <label for="unique-0-0">Unique</label>
                                                </div>

                                                {{-- Basic --}}
                                                <div class="input-field col m3 s6">
                                                    <input class="with-gap" name="models[0][fields][0][index]"
                                                           type="radio"
                                                           id="basicIndex-0-0" value="index"/>
                                                    <label for="basicIndex-0-0">Basic</label>
                                                </div>

                                                <div class="input-field col m12 s12">
                                                    <br><h6 class="center-align">Options</h6>
                                                </div>

                                                {{-- Hide in listings --}}
                                                <div class="input-field col m12 s12">
                                                    <input type="hidden" name="models[0][fields][0][hideInListings]"
                                                           value="false"/>
                                                    <input type="checkbox" id="hideInListings-0-0"
                                                           name="models[0][fields][0][hideInListings]" value="true"/>
                                                    <label for="hideInListings-0-0">Hide in listings</label>
                                                </div>
                                            </div>

                                            <div id="field-0-1" class="row z-depth-1">

                                                {{-- Remove field FAB --}}
                                                <a onclick="$.removeField(0, 1)"
                                                   class="btn-floating waves-effect waves-light pink darken-1 remove-field-fab"
                                                   data-delay="0">
                                                    <i class="material-icons">remove</i>
                                                </a>

                                                {{-- Field name --}}
                                                <div class="input-field col m6 s12">
                                                    <input id="fieldName-0-1" name="models[0][fields][1][name]"
                                                           type="text"
                                                           class="validate typeahead">
                                                    <label for="fieldName-0-1">Field name</label>
                                                </div>

                                                {{-- Validations --}}
                                                <div class="input-field col m6 s12">
                                                    <input id="validations-0-1" name="models[0][fields][1][validations]"
                                                           type="text"
                                                           class="validate typeahead">
                                                    <label for="validations-0-1">Validations</label>
                                                </div>

                                                {{-- Database type --}}
                                                <div class="input-field col m6 s12">
                                                    <input id="databaseType-0-1" name="models[0][fields][1][type][db]"
                                                           type="text"
                                                           class="validate typeahead">
                                                    <label for="databaseType-0-1">Database type</label>
                                                </div>

                                                {{-- UI type --}}
                                                <div class="input-field col m6 s12">
                                                    <input id="uiType-0-1" name="models[0][fields][1][type][ui]"
                                                           type="text"
                                                           class="validate typeahead">
                                                    <label for="uiType-0-1">UI type</label>
                                                </div>

                                                {{-- Modifiers --}}
                                                <div class="input-field col m12 s12">
                                                    <input id="modifiers-0-1" name="models[0][fields][1][modifiers]"
                                                           type="text"
                                                           class="validate typeahead"
                                                           placeholder="e.g. modifier_1:modifier_2">
                                                    <label for="modifiers-0-1">Modifiers</label>
                                                </div>

                                                {{-- Foreign key --}}
                                                <div class="input-field col m12 s12">
                                                    <input id="foreignKey-0-1" name="models[0][fields][1][foreignKey]"
                                                           type="text"
                                                           class="validate typeahead"
                                                           placeholder="field:table:referential option">
                                                    <label for="foreignKey-0-1">Foreign key</label>
                                                </div>

                                                <div class="input-field col m12 s12">
                                                    <h6 class="center-align">Index types</h6>
                                                </div>

                                                {{-- No index --}}
                                                <div class="input-field col m3 s6">
                                                    <input class="with-gap" name="models[0][fields][1][index]"
                                                           type="radio"
                                                           id="none-0-1" value="none" checked>
                                                    <label for="none-0-1">None</label>
                                                </div>

                                                {{-- Primary --}}
                                                <div class="input-field col m3 s6">
                                                    <input class="with-gap" name="models[0][fields][1][index]"
                                                           type="radio"
                                                           id="primaryKey-0-1" value="primary"/>
                                                    <label for="primaryKey-0-1">Primary</label>
                                                </div>

                                                {{-- Unique --}}
                                                <div class="input-field col m3 s6">
                                                    <input class="with-gap" name="models[0][fields][1][index]"
                                                           type="radio"
                                                           id="unique-0-1" value="unique"/>
                                                    <label for="unique-0-1">Unique</label>
                                                </div>

                                                {{-- Basic --}}
                                                <div class="input-field col m3 s6">
                                                    <input class="with-gap" name="models[0][fields][1][index]"
                                                           type="radio"
                                                           id="basicIndex-0-1" value="index"/>
                                                    <label for="basicIndex-0-1">Basic</label>
                                                </div>

                                                <div class="input-field col m12 s12">
                                                    <br><h6 class="center-align">Options</h6>
                                                </div>

                                                {{-- Hide in listings --}}
                                                <div class="input-field col m12 s12">
                                                    <input type="hidden" name="models[0][fields][1][hideInListings]"
                                                           value="false"/>
                                                    <input type="checkbox" id="hideInListings-0-1"
                                                           name="models[0][fields][1][hideInListings]" value="true"/>
                                                    <label for="hideInListings-0-1">Hide in listings</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    {{-- Side nav --}}
    <asside class="col hide-on-med-and-down">
        <ul class="section table-of-contents z-depth-1">
            <li><a href="#application-settings-section">Application settings</a></li>
            <li><a href="#user-interface-section">User interface</a></li>
            <li><a href="#paths-section">Paths</a></li>
            <li><a href="#namespaces-section">Namespaces</a></li>
            <li><a href="#inheritances-section">Inheritances</a></li>
            <li><a href="#routing-section">Routing</a></li>
            <li><a href="#api-section">API</a></li>
            <li><a href="#theme-extensions-section">Theme extensions</a></li>
            <li><a href="#extensions-section">Extensions</a></li>
            <li><a href="#model-generation-section">Model generation</a></li>
        </ul>
    </asside>

    {{-- Main FAB --}}
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large waves-effect waves-light pink darken-1">
            <i class="large material-icons">settings</i>
        </a>
        <ul>
            <li>
                <a id="clearAll" class="btn-floating waves-effect waves-light tooltipped red" data-position="left"
                   data-delay="0" data-tooltip="Clear all">
                    <i class="material-icons">clear_all</i>
                </a>
            </li>
            <li>
                <a id="shortcuts" class="btn-floating waves-effect waves-light tooltipped modal-trigger blue"
                   data-position="left" data-delay="0" data-tooltip="View keyboard shortcuts"
                   href="#keyboard-shortcuts-modal">
                    <i class="material-icons">keyboard</i>
                </a>
            </li>
            <li>
                <a id="scaffoldWithApi" class="btn-floating waves-effect waves-light tooltipped green" data-position="left"
                   data-delay="0" data-tooltip="Scaffold with API">
                    <i class="material-icons">done_all</i>
                </a>
            </li>
            <li>
                <a id="scaffold" class="btn-floating waves-effect waves-light tooltipped green"
                   data-position="left" data-delay="0" data-tooltip="Scaffold">
                    <i class="material-icons">done</i>
                </a>
            </li>
            <li>
                <a id="addModel" class="btn-floating waves-effect waves-light tooltipped blue" data-position="left"
                   data-delay="0" data-tooltip="Add model">
                    <i class="material-icons">add</i>
                </a>
            </li>
        </ul>
    </div>

    {{-- Scaffold output modal --}}
    <div id="scaffold-output-modal" class="modal bottom-sheet modal-fixed-footer">
        <div class="modal-content">
            <ul id="scaffold-output-container" class="collection"></ul>
        </div>
        <div class="modal-footer">
            <div class="row" style="display: flex; align-items: center; margin-bottom: 0;">
                <div class="col s10">
                    <div id="scaffold-output-progress" class="progress" style="display: none; margin-top: 15px;">
                        <div class="indeterminate"></div>
                    </div>
                </div>
                <div class="col s2">
                    <a href="#!" class="modal-action modal-close waves-effect btn-flat">Close</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Keyboard shortcuts modal --}}
    <div id="keyboard-shortcuts-modal" class="modal">
        <div class="modal-content">
            <h4>Keyboard shortcuts</h4>
        </div>
        <table class="centered">
            <thead>
            <tr>
                <th data-field="keys">Keys</th>
                <th data-field="action">Action</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>a + b</td>
                <td>Add model</td>
            </tr>
            <tr>
                <td>a + c</td>
                <td>Generate</td>
            </tr>
            <tr>
                <td>a + d</td>
                <td>Generate with API</td>
            </tr>
            <tr>
                <td>a + e</td>
                <td>Clear all</td>
            </tr>
            </tbody>
        </table>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect btn-flat">Close</a>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="page-footer grey darken-3">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">Footer Content</h5>

                    <p class="grey-text text-lighten-4">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci dolorem, dolores esse eum
                        facere harum in iusto laudantium quam quidem, quo quos temporibus tenetur veniam voluptatibus!
                        Harum molestias nostrum veniam?
                    </p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Cool stuff</h5>
                    <ul>
                        <li>
                            <a class="grey-text text-lighten-3" target="_blank"
                               href="https://github.com/mpociot/teamwork">
                                Team system
                            </a>
                        </li>
                        <li>
                            <a class="grey-text text-lighten-3" target="_blank"
                               href="https://github.com/lucadegasperi/oauth2-server-laravel">
                                OAuth2 server
                            </a>
                        </li>
                        <li>
                            <a class="grey-text text-lighten-3" target="_blank"
                               href="https://github.com/ARCANEDEV/LogViewer">
                                Log viewer
                            </a>
                        </li>
                        <li>
                            <a class="grey-text text-lighten-3" target="_blank"
                               href="https://github.com/Zizaco/entrust">
                                Role based permissions
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                {{ date('Y') }} Laravel scaffolder
                <a class="grey-text text-lighten-4 right" href="https://en.wikipedia.org/wiki/Uruguay"
                   target="_blank">
                    Made with <i class="tiny material-icons pink-text">favorite</i> in Uruguay
                </a>
            </div>
        </div>
    </footer>

    {{-- Typeahead --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

    <script>
        $(document).ready(function ()
        {
            /*
             |--------------------------------------------------------------------------
             | User interface
             |--------------------------------------------------------------------------
             */

            function UI()
            {
                // Content
                this.outputModalContent = $('#scaffold-output-modal .modal-content');
                // Collections
                this.modelsCollection = $('#models-collection');
                this.outputCollection = $('#scaffold-output-container');
                // Components
                this.formComponent = $('form');
                this.selectComponent = $('select');
                this.assideComponent = $('asside');
                this.typeaheadComponent = $('.typeahead');
                this.scrollSpyComponent = $('.scrollspy');
                this.outputModalComponent = $('#scaffold-output-modal');
                this.outputProgressComponent = $('#scaffold-output-progress');
                // Buttons
                this.clearAllButton = $('#clearAll');
                this.scaffoldButton = $('#scaffold');
                this.scaffoldWithApiButton = $('#scaffoldWithApi');
                this.addModelButton = $('#addModel');
                // Triggers
                this.modalTrigger = $('.modal-trigger');
            }

            /*
             |--------------------------------------------------------------------------
             | Http communication
             |--------------------------------------------------------------------------
             */

            function Http(ui)
            {
                var self = this;
                this.ui = ui;

                this.scaffold = function (title, url)
                {
                    self.ui.outputProgressComponent.fadeIn('slow');

                    $.post(url, self.ui.formComponent.serialize(), function ()
                    {
                        self.ui.outputCollection.append('<li class=\"collection-item teal-text\">' + title + '</li>');
                        self.ui.outputModalContent.animate({scrollTop: self.ui.outputModalContent[0].scrollHeight}, 1000);
                        self.ui.outputModalComponent.openModal({dismissible: false});

                        var lastStatusMessagePosition = 0;

                        var getStatus = function ()
                        {
                            $.get('/scaffolder/status', function (data)
                            {
                                if (lastStatusMessagePosition != data.length)
                                {
                                    for (var i = lastStatusMessagePosition; i < data.length; i++)
                                    {
                                        self.ui.outputCollection.append('<li class=\"collection-item\">' + data[i] + '</li>');
                                    }

                                    self.ui.outputModalContent.animate({scrollTop: self.ui.outputModalContent[0].scrollHeight}, 1000);

                                    lastStatusMessagePosition = data.length;

                                    if (data[data.length - 1] != 'Done' && data[data.length - 1] != 'Error')
                                    {
                                        setTimeout(function ()
                                        {
                                            getStatus();
                                        }, 1500);
                                    }
                                    else
                                    {
                                        self.ui.outputProgressComponent.fadeOut('slow');
                                    }
                                }
                                else
                                {
                                    if (data[data.length - 1] != 'Done' && data[data.length - 1] != 'Error')
                                    {
                                        setTimeout(function ()
                                        {
                                            getStatus();
                                        }, 3000);
                                    }
                                }
                            });
                        };

                        getStatus();
                    });
                }
            }

            /*
             |--------------------------------------------------------------------------
             | Application actions
             |--------------------------------------------------------------------------
             */

            function App(http, ui)
            {
                var self = this;
                this.modelId = 1;
                this.http = http;
                this.ui = ui;

                this.init = function ()
                {
                    // Ajax settings
                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

                    // Select
                    self.ui.selectComponent.material_select();

                    // Scrollspy
                    self.ui.scrollSpyComponent.scrollSpy();

                    // Pushpin
                    self.ui.assideComponent.pushpin({
                        top: 100
                    });

                    // Modal
                    self.ui.modalTrigger.leanModal();
                }

                this.bindActions = function ()
                {
                    // Clear all
                    self.ui.clearAllButton.click(function (event)
                    {
                        event.preventDefault();

                        self.ui.formComponent[0].reset();

                        Materialize.toast('Data cleared', 3000);
                    });

                    // Scaffold
                    self.ui.scaffoldButton.click({http: self.http}, function (event)
                    {
                        event.preventDefault();
                        http.scaffold('Scaffolding', '/scaffolder/generate');
                    });

                    // Scaffold with API
                    self.ui.scaffoldWithApiButton.click({http: self.http}, function (event)
                    {
                        event.preventDefault();
                        http.scaffold('Scaffolding with API', '/scaffolder/generate-with-api');
                    });

                    // Add model
                    self.ui.addModelButton.click(function (event)
                    {
                        event.preventDefault();

                        self.modelId++;

                        $('<div id=\'modelId-' + self.modelId + '\'>').load('/scaffolder/add-model', {
                            'modelId': self.modelId
                        }, function ()
                        {
                            self.ui.modelsCollection.append($(this));

                            self.ui.typeaheadComponent.typeahead('destroy');

                            self.initTypeahead();
                        });

                        Materialize.toast('Model added', 3000);
                    });
                }

                this.addField = function (modelId)
                {
                    var fieldId = $('#modelId-' + modelId + ' .fields > div').length;

                    $('<div id=\'field-' + modelId + '-' + fieldId + '\' class=\'row z-depth-1\'>').load('/scaffolder/add-field', {
                        'modelId': modelId,
                        'fieldId': fieldId
                    }, function ()
                    {
                        $('#modelId-' + modelId + ' .fields').append($(this));

                        self.ui.typeaheadComponent.typeahead('destroy');

                        self.initTypeahead();
                    });

                    Materialize.toast('Field added', 3000);
                }

                this.removeModel = function (modelId)
                {
                    $('#modelId-' + modelId).remove();
                }

                this.removeField = function (modelId, fieldId)
                {
                    $('#field-' + modelId + '-' + fieldId).remove();
                }

                this.initTypeahead = function ()
                {
                    var typeaheadValues = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.whitespace,
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        local: [
                            // Validations
                            'accepted',
                            'active_url',
                            'after:',
                            'alpha',
                            'alpha_dash',
                            'alpha_num',
                            'array',
                            'before:',
                            'between:',
                            'boolean',
                            'confirmed',
                            'date',
                            'date_format',
                            'different',
                            'digits',
                            'digits_between:',
                            'email',
                            'exists:',
                            'image',
                            'in:',
                            'integer',
                            'ip',
                            'json',
                            'max:',
                            'mimes:',
                            'min:',
                            'not_in:',
                            'numeric',
                            'regex:',
                            'required',
                            'required_if:',
                            'required_with',
                            'required_with_all:',
                            'required_without:',
                            'same:',
                            'size:',
                            'string',
                            'timezone',
                            'unique:',
                            'url',
                            'alpha_dash',
                            // Database types
                            'bigInteger',
                            'binary',
                            'boolean',
                            'char',
                            'date',
                            'dateTime',
                            'decimal',
                            'double',
                            'enum',
                            'float',
                            'integer',
                            'json',
                            'jsonb',
                            'longText',
                            'mediumInteger',
                            'mediumText',
                            'morphs',
                            'nullableTimestamps',
                            'rememberToken',
                            'smallInteger',
                            'string',
                            'text',
                            'time',
                            'tinyInteger',
                            'timestamp',
                            // UI types
                            'text',
                            'textarea',
                            'dropDownList',
                            'checkBox',
                            'radioButton',
                            'number',
                            'date'
                        ]
                    });

                    self.ui.typeaheadComponent.typeahead({
                        hint: false,
                        highlight: true,
                        minLength: 1
                    }, {
                        name: 'typeahead',
                        source: typeaheadValues
                    }).unwrap();
                }
            }

            /*
             |--------------------------------------------------------------------------
             | Application setup
             |--------------------------------------------------------------------------
             */

            var ui = new UI();
            var http = new Http(ui);
            var app = new App(http, ui);

            app.init();
            app.bindActions();
            app.initTypeahead();

            /*
             |--------------------------------------------------------------------------
             | Expose UI methods
             |--------------------------------------------------------------------------
             */

            $.addField = function (modelId)
            {
                app.addField(modelId);
            };

            $.removeModel = function (modelId)
            {
                app.removeModel(modelId);
            };

            $.removeField = function (modelId, fieldId)
            {
                app.removeField(modelId, fieldId);
            };
        });
    </script>
</body>
</html>
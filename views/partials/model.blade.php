<div class="col l6 s10 offset-l3 offset-s1">

    {{-- Add field FAB --}}
    <a onclick="addField({{ $modelId }})"
       class="btn-floating waves-effect waves-light pink darken-1 add-field-fab" data-position="right">
        <i class="material-icons">add</i>
    </a>

    {{-- Remove model FAB --}}
    <a onclick="removeModel({{ $modelId }})"
       class="btn-floating waves-effect waves-light pink darken-1 remove-model-fab" data-position="right">
        <i class="material-icons">remove</i>
    </a>

    <div class="card-panel">
        <div class="section">
            <div class="row">
                <div class="row">

                    {{-- Model name --}}
                    <div class="input-field col m4 s12">
                        <input id="modelName-{{ $modelId }}" name="models[{{ $modelId }}][modelName]" type="text"
                               class="validate">
                        <label for="modelName-{{ $modelId }}">Model name</label>
                    </div>

                    {{-- Model label --}}
                    <div class="input-field col m4 s12">
                        <input id="modelName-{{ $modelId }}" name="models[{{ $modelId }}][modelLabel]" type="text"
                               class="validate">
                        <label for="modelLabel-{{ $modelId }}">Model label</label>
                    </div>

                    {{-- Table name --}}
                    <div class="input-field col m4 s12">
                        <input id="modelName-{{ $modelId }}" name="models[{{ $modelId }}][tableName]" type="text"
                               class="validate">
                        <label for="tableName-{{ $modelId }}">Table name</label>
                    </div>

                    {{-- Skip migration --}}
                    <div class="input-field col m3 s6">
                        <input type="hidden" name="models[{{ $modelId }}][skipMigration]"
                               value="false"/>
                        <input type="checkbox" id="skipMigration-{{ $modelId }}"
                               name="models[{{ $modelId }}][skipMigration]" value="true"/>
                        <label for="skipMigration-{{ $modelId }}">Skip migration</label>
                    </div>

                    {{-- Skip model --}}
                    <div class="input-field col m3 s6">
                        <input type="hidden" name="models[{{ $modelId }}][skipModel]"
                               value="false"/>
                        <input type="checkbox" id="skipModel-{{ $modelId }}"
                               name="models[{{ $modelId }}][skipModel]" value="true"/>
                        <label for="skipModel-{{ $modelId }}">Skip model</label>
                    </div>

                    {{-- Skip controller --}}
                    <div class="input-field col m3 s6">
                        <input type="hidden" name="models[{{ $modelId }}][skipController]"
                               value="false"/>
                        <input type="checkbox" id="skipController-{{ $modelId }}"
                               name="models[{{ $modelId }}][skipController]" value="true"/>
                        <label for="skipController-{{ $modelId }}">Skip controller</label>
                    </div>

                    {{-- Skip views --}}
                    <div class="input-field col m3 s6">
                        <input type="hidden" name="models[{{ $modelId }}][skipViews]"
                               value="false"/>
                        <input type="checkbox" id="skipViews-{{ $modelId }}"
                               name="models[{{ $modelId }}][skipViews]" value="true"/>
                        <label for="skipViews-{{ $modelId }}">Skip views</label>
                    </div>
                </div>

                <div class="fields col s12">

                    <div id="field-{{ $modelId }}-0" class="row z-depth-1">

                        {{-- Remove field FAB--}}
                        <a onclick="removeField({{ $modelId }}, 0)"
                           class="btn-floating waves-effect waves-light pink darken-1 remove-field-fab"
                           data-position="right"><i
                                    class="material-icons">remove</i></a>

                        {{-- Field name --}}
                        <div class="input-field col m6 s12">
                            <input id="fieldName-{{ $modelId }}-0" name="models[{{ $modelId }}][fields][0][name]"
                                   type="text"
                                   class="validate typeahead">
                            <label for="fieldName-{{ $modelId }}-0">Field name</label>
                        </div>

                        {{-- Validations --}}
                        <div class="input-field col m6 s12">
                            <input id="validations-{{ $modelId }}-0"
                                   name="models[{{ $modelId }}][fields][0][validations]"
                                   type="text"
                                   class="validate typeahead">
                            <label for="validations-{{ $modelId }}-0">Validations</label>
                        </div>

                        {{-- Database type --}}
                        <div class="input-field col m6 s12">
                            <input id="databaseType-{{ $modelId }}-0" name="models[{{ $modelId }}][fields][0][type][db]"
                                   type="text"
                                   class="validate typeahead">
                            <label for="databaseType-{{ $modelId }}-0">Database type</label>
                        </div>

                        {{-- UI type --}}
                        <div class="input-field col m6 s12">
                            <input id="uiType-{{ $modelId }}-0" name="models[{{ $modelId }}][fields][0][type][ui]"
                                   type="text"
                                   class="validate typeahead">
                            <label for="uiType-{{ $modelId }}-0">UI type</label>
                        </div>

                        {{-- Modifiers --}}
                        <div class="input-field col m12 s12">
                            <input id="modifiers-{{ $modelId }}-0" name="models[{{ $modelId }}][fields][0][modifiers]"
                                   type="text"
                                   class="validate typeahead">
                            <label for="modifiers-{{ $modelId }}-0">Modifiers</label>
                        </div>

                        {{-- Foreign key --}}
                        <div class="input-field col m12 s12">
                            <input id="foreignKey-{{ $modelId }}-0" name="models[{{ $modelId }}][fields][0][foreignKey]"
                                   type="text"
                                   class="validate typeahead">
                            <label for="foreignKey-{{ $modelId }}-0">Foreign key</label>
                        </div>

                        <div class="input-field col m12 s12">
                            <h6 class="center-align">Indexes</h6>
                        </div>

                        {{-- No index --}}
                        <div class="input-field col m3 s6">
                            <input class="with-gap" name="models[{{ $modelId }}][fields][0][index]"
                                   type="radio"
                                   id="none-{{ $modelId }}-0" value="none" checked>
                            <label for="none-{{ $modelId }}-0">None</label>
                        </div>

                        {{-- Primary --}}
                        <div class="input-field col m3 s6">
                            <input class="with-gap" name="models[{{ $modelId }}][fields][0][index]"
                                   type="radio"
                                   id="primaryKey-{{ $modelId }}-0" value="primary"/>
                            <label for="primaryKey-{{ $modelId }}-0">Primary</label>
                        </div>

                        {{-- Unique --}}
                        <div class="input-field col m3 s6">
                            <input class="with-gap" name="models[{{ $modelId }}][fields][0][index]"
                                   type="radio"
                                   id="unique-{{ $modelId }}-0" value="unique"/>
                            <label for="unique-{{ $modelId }}-0">Unique</label>
                        </div>

                        {{-- Basic --}}
                        <div class="input-field col m3 s6">
                            <input class="with-gap" name="models[{{ $modelId }}][fields][0][index]"
                                   type="radio"
                                   id="basicIndex-{{ $modelId }}-0" value="index"/>
                            <label for="basicIndex-{{ $modelId }}-0">Basic</label>
                        </div>

                        <div class="input-field col m12 s12">
                            <br><h6 class="center-align">Options</h6>
                        </div>

                        {{-- Hide in listings --}}
                        <div class="input-field col m12 s12">
                            <input type="hidden" name="models[{{ $modelId }}][fields][0][hideInListings]"
                                   value="false"/>
                            <input type="checkbox" id="hideInListings-{{ $modelId }}-0"
                                   name="models[{{ $modelId }}][fields][0][hideInListings]" value="true"/>
                            <label for="hideInListings-{{ $modelId }}-0">Hide in listings</label>
                        </div>
                    </div>

                    <div id="field-{{ $modelId }}-1" class="row z-depth-1">

                        {{-- Remove field FAB --}}
                        <a onclick="removeField({{ $modelId }}, 1)"
                           class="btn-floating waves-effect waves-light pink darken-1 remove-field-fab"
                           data-position="right"><i
                                    class="material-icons">remove</i></a>

                        {{-- Field name --}}
                        <div class="input-field col m6 s12">
                            <input id="fieldName-{{ $modelId }}-1" name="models[{{ $modelId }}][fields][1][name]"
                                   type="text"
                                   class="validate typeahead">
                            <label for="fieldName-{{ $modelId }}-1">Field name</label>
                        </div>

                        {{-- Validations --}}
                        <div class="input-field col m6 s12">
                            <input id="validations-{{ $modelId }}-1"
                                   name="models[{{ $modelId }}][fields][1][validations]"
                                   type="text"
                                   class="validate typeahead">
                            <label for="validations-{{ $modelId }}-1">Validations</label>
                        </div>

                        {{-- Database type--}}
                        <div class="input-field col m6 s12">
                            <input id="databaseType-{{ $modelId }}-1" name="models[{{ $modelId }}][fields][1][type][db]"
                                   type="text"
                                   class="validate typeahead">
                            <label for="databaseType-{{ $modelId }}-1">Database type</label>
                        </div>

                        {{-- UI type --}}
                        <div class="input-field col m6 s12">
                            <input id="uiType-{{ $modelId }}-1" name="models[{{ $modelId }}][fields][1][type][ui]"
                                   type="text"
                                   class="validate typeahead">
                            <label for="uiType-{{ $modelId }}-1">UI type</label>
                        </div>

                        {{-- Modifiers --}}
                        <div class="input-field col m12 s12">
                            <input id="modifiers-{{ $modelId }}-1" name="models[{{ $modelId }}][fields][1][modifiers]"
                                   type="text"
                                   class="validate typeahead">
                            <label for="modifiers-{{ $modelId }}-1">Modifiers</label>
                        </div>

                        {{-- Foreign key --}}
                        <div class="input-field col m12 s12">
                            <input id="foreignKey-{{ $modelId }}-1" name="models[{{ $modelId }}][fields][1][foreignKey]"
                                   type="text"
                                   class="validate typeahead">
                            <label for="foreignKey-{{ $modelId }}-1">Foreign key</label>
                        </div>

                        <div class="input-field col m12 s12">
                            <h6 class="center-align">Indexes</h6>
                        </div>

                        {{-- No index --}}
                        <div class="input-field col m3 s6">
                            <input class="with-gap" name="models[{{ $modelId }}][fields][1][index]"
                                   type="radio"
                                   id="none-{{ $modelId }}-1" value="none" checked>
                            <label for="none-{{ $modelId }}-1">None</label>
                        </div>

                        {{-- Primary --}}
                        <div class="input-field col m3 s6">
                            <input class="with-gap" name="models[{{ $modelId }}][fields][1][index]"
                                   type="radio"
                                   id="primaryKey-{{ $modelId }}-1" value="primary"/>
                            <label for="primaryKey-{{ $modelId }}-1">Primary</label>
                        </div>

                        {{-- Unique --}}
                        <div class="input-field col m3 s6">
                            <input class="with-gap" name="models[{{ $modelId }}][fields][1][index]"
                                   type="radio"
                                   id="unique-{{ $modelId }}-1" value="unique"/>
                            <label for="unique-{{ $modelId }}-1">Unique</label>
                        </div>

                        {{-- Basic --}}
                        <div class="input-field col m3 s6">
                            <input class="with-gap" name="models[{{ $modelId }}][fields][1][index]"
                                   type="radio"
                                   id="basicIndex-{{ $modelId }}-1" value="index"/>
                            <label for="basicIndex-{{ $modelId }}-1">Basic</label>
                        </div>

                        <div class="input-field col m12 s12">
                            <br><h6 class="center-align">Options</h6>
                        </div>

                        {{-- Hide in listings --}}
                        <div class="input-field col m12 s12">
                            <input type="hidden" name="models[{{ $modelId }}][fields][1][hideInListings]"
                                   value="false"/>
                            <input type="checkbox" id="hideInListings-{{ $modelId }}-1"
                                   name="models[{{ $modelId }}][fields][1][hideInListings]" value="true"/>
                            <label for="hideInListings-{{ $modelId }}-1">Hide in listings</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
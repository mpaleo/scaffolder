<a onclick="$.removeField({{ $modelId }}, {{ $fieldId }})"
   class="btn-floating waves-effect waves-light pink darken-1 remove-field-fab"
   data-position="right" data-delay="0"><i
            class="material-icons">remove</i></a>

<div class="input-field col m6 s12">
    <input id="fieldName-{{ $modelId . '-' . $fieldId }}" name="models[{{ $modelId }}][fields][{{ $fieldId }}][name]"
           type="text"
           class="validate typeahead">
    <label for="fieldName-{{ $modelId . '-' . $fieldId }}">Field name</label>
</div>

<div class="input-field col m6 s12">
    <input id="validations-{{ $modelId . '-' . $fieldId }}" name="models[{{ $modelId }}][fields][{{ $fieldId }}][validations]"
           type="text"
           class="validate typeahead">
    <label for="validations-{{ $modelId . '-' . $fieldId }}">Validations</label>
</div>

<div class="input-field col m6 s12">
    <input id="databaseType-{{ $modelId . '-' . $fieldId }}" name="models[{{ $modelId }}][fields][{{ $fieldId }}][type][db]"
           type="text"
           class="validate typeahead">
    <label for="databaseType-{{ $modelId . '-' . $fieldId }}">Database type</label>
</div>

<div class="input-field col m6 s12">
    <input id="uiType-{{ $modelId . '-' . $fieldId }}" name="models[{{ $modelId }}][fields][{{ $fieldId }}][type][ui]"
           type="text"
           class="validate typeahead">
    <label for="uiType-{{ $modelId . '-' . $fieldId }}">UI type</label>
</div>

{{-- Modifiers --}}
<div class="input-field col m12 s12">
    <input id="modifiers-{{ $modelId . '-' . $fieldId }}" name="models[{{ $modelId }}][fields][{{ $fieldId }}][modifiers]"
           type="text"
           class="validate typeahead">
    <label for="modifiers-{{ $modelId . '-' . $fieldId }}">Modifiers</label>
</div>

{{-- Foreign key --}}
<div class="input-field col m12 s12">
    <input id="foreignKey-{{ $modelId . '-' . $fieldId }}" name="models[{{ $modelId }}][fields][{{ $fieldId }}][foreignKey]"
           type="text"
           class="validate typeahead">
    <label for="foreignKey-{{ $modelId . '-' . $fieldId }}">Foreign key</label>
</div>

<div class="input-field col m12 s12">
    <h6 class="center-align">Indexes</h6>
</div>

{{-- No index --}}
<div class="input-field col m3 s6">
    <input class="with-gap" name="models[{{ $modelId }}][fields][{{ $fieldId }}][index]"
           type="radio"
           id="none-{{ $modelId . '-' . $fieldId }}" value="none" checked>
    <label for="none-{{ $modelId . '-' . $fieldId }}">None</label>
</div>

{{-- Primary key --}}
<div class="input-field col m3 s6">
    <input class="with-gap" name="models[{{ $modelId }}][fields][{{ $fieldId }}][index]"
           type="radio"
           id="primaryKey-{{ $modelId . '-' . $fieldId }}" value="primary"/>
    <label for="primaryKey-{{ $modelId . '-' . $fieldId }}">Primary</label>
</div>

{{-- Unique --}}
<div class="input-field col m3 s6">
    <input class="with-gap" name="models[{{ $modelId }}][fields][{{ $fieldId }}][index]"
           type="radio"
           id="unique-{{ $modelId . '-' . $fieldId }}" value="unique"/>
    <label for="unique-{{ $modelId . '-' . $fieldId }}">Unique</label>
</div>

{{-- Basic --}}
<div class="input-field col m3 s6">
    <input class="with-gap" name="models[{{ $modelId }}][fields][{{ $fieldId }}][index]"
           type="radio"
           id="basicIndex-{{ $modelId . '-' . $fieldId }}" value="index"/>
    <label for="basicIndex-{{ $modelId . '-' . $fieldId }}">Basic</label>
</div>

<div class="input-field col m12 s12">
    <br><h6 class="center-align">Options</h6>
</div>

{{-- Hide in listings --}}
<div class="input-field col m12 s12">
    <input type="hidden" name="models[{{ $modelId }}][fields][{{ $fieldId }}][hideInListings]"
           value="false"/>
    <input type="checkbox" id="hideInListings-{{ $modelId . '-' . $fieldId }}"
           name="models[{{ $modelId }}][fields][{{ $fieldId }}][hideInListings]"/>
    <label for="hideInListings-{{ $modelId . '-' . $fieldId }}">Hide in listings</label>
</div>
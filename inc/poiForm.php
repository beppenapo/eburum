<div id="newPoi">
    <input type="hidden" name="fid" id="fid" value="" >
    <textarea name="nomePoi" class="newPoi" placeholder="nome punto"></textarea>
    <select name="tipoPoi" class="newPoi">
        <option value="" selected>-- scegli tipologia --</option>
        <?php  echo $tipoList; ?>
    </select>
    <select name="scPoi" class="newPoi">
        <option value="" selected>-- stato di conservazione --</option>
        <?php  echo $scList; ?>
    </select>
    <select name="accPoi" class="newPoi">
        <option value="" selected>-- accessibilità punto--</option>
        <?php  echo $accList; ?>
    </select>
    <label for="disPoi" class="pointer newPoi labelForm" id="disPoiLab"><input id="disPoi" type="checkbox" name="disPoi"> Area accessibile ai disabili</label>
    <textarea name="descPoi" class="newPoi" placeholder="aggiungi una descrizione al punto"></textarea>
    <button type="button" name="salva" class="button">salva punto</button>
    <button type="button" name="annulla" class="button">annulla inserimento</button>
    <span id="errori" class="error"></span>
</div>
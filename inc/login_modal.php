<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Accedi al sistema</a></h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <form id="loginForm" name="loginForm" accept-charset="utf-8">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-at" aria-hidden="true"></i></span>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="inserisci email" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="inserisci password" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="loginSubmit">login</button>
                                    <label id="msgLogin"></label>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Password dimenticata</a></h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <label>Per motivi di sicurezza le mail salvate nel database sono criptate e non è possibile recuperarle. Ad ogni richiesta di recupero password il sistema ne crea una nuova che verrà inviata via mail.<br />Per generare la nuova password inserisci nel form sottostante l'indirizzo di posta elettronica utilizzato al momento della registrazione.<br/>Se la mail non ti arriva controlla nella spam.<br />Se continui ad avere problemi di ricezione contatta beppenapo[at]arc-team.com</label>
                                <form id="rescueForm" name="rescueForm" accept-charset="utf-8">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-at" aria-hidden="true"></i></span>
                                            <input type="email" class="form-control" name="rescueEmail" id="rescueEmail" placeholder="inserisci email" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="rescueSubmit">rigenera password</button>
                                    <label id="msgRecupera"></label>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Crea account</a></h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                <h4>Grazie per aver deciso di collaborare!</h4>
                                <label>Per creare un nuovo account devi solo inserire una mail di riferimento. Il sistema creerà una nuova password che ti verrà inviata all'indirizzo mail inserito.<br/>Nel rispetto della privacy, le mail inserite verranno salvate all'interno di un database ed utilizzate esclusivamente per l'accesso al sistema, non verranno utilizzate per scopi commerciali e non verranno cedute a terzi per fini di lucro.
                                </label>
                                <form id="newForm" name="newForm" accept-charset="utf-8">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-at" aria-hidden="true"></i></span>
                                            <input type="email" class="form-control" name="newEmail" id="newEmail" placeholder="inserisci email" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="newUsrSubmit">crea account</button>
                                    <label id="msgCrea"></label>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id="output"></div>
                <div id="sec"></div>
            </div>
        </div>
    </div>
</div>

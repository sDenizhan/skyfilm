
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span class="mws-i-24 i-list">Kategori Düzelt</span>
                    </div>
                    <div class="mws-panel-body">
                    	<?php echo form_open('admin/bloglar/kategoriduzeltkaydet/'. $_kategori->row()->f_ID .'/'. seoURL($_kategori->row()->f_KategoriAdi) .'', 'class="mws-form"'); ?>
                    		<div class="mws-form-inline">
                    			<div class="mws-form-row">
                    				<label>Kategori Adı</label>
                    				<div class="mws-form-item large">
                    					<input type="text" class="mws-textinput" id="frmKategoriAdi" name="frmKategoriAdi" value="<?php echo $_kategori->row()->f_KategoriAdi; ?>" />
                    				</div>
                    			</div>
                    			<div class="mws-form-row">
                    				<label>Üst Kategoriyi Seçin</label>
                    				<div class="mws-form-item small">
                    					<select id="frmUstKategori" name="frmUstKategori">
										<option value="0|AnaKategori">Ana Kategori</option>
										<?php 
											if (isset($_ustkat)) {
													foreach ($_ustkat->result() as $_row) {
														// üst kategoriler
														if ($_row->f_ID == $_kategori->row()->f_UstKategoriID ) {
															echo '<option value="'. $_row->f_ID .'" selected="selected">'.$_row->f_KategoriAdi .'</option>';
														} else {
															echo '<option value="'. $_row->f_ID .'">'.$_row->f_KategoriAdi .'</option>';
														}

														foreach ($_altkat->result() as $_r) {
															if ($_r->f_UstKategoriID == $_row->f_ID ) {
																if ($_r->f_ID == $_kategori->row()->f_UstKategoriID ) {
																	echo '<option value="'. $_r->f_ID .'" selected="selected">-'.$_r->f_KategoriAdi .'</option>';
																} else {
																	echo '<option value="'. $_r->f_ID .'">-'.$_r->f_KategoriAdi .'</option>';
																}
															}
														}
													}
												}
										?>
										</select>
                    				</div>
                    			</div>
                    		</div>
                    		<div class="mws-button-row">
                    			<input type="reset" value="Forumu Temizle" class="mws-button green" />
                    			<input type="submit" value="Kategori Düzelt" class="mws-button red" />
                    		</div>
                    	<?php echo form_close(); ?>
                    </div>    	
                </div>

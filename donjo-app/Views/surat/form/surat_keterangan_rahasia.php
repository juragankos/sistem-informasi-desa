<script>
    $(function() {
        var nik = {};
        nik.results = [
            <?php  foreach($penduduk as $data){?> {
                id: '<?php echo $data['id']?>',
                name: "<?php echo $data['nik']." - ".($data['nama'])?>",
                info: "<?php echo ($data['alamat'])?>"
            },
            <?php  }?>
        ];
        $('#nik').flexbox(nik, {
            resultTemplate: '<div><label>No nik : </label>{name}</div><div>{info}</div>',
            watermark: <?php  if($individu){?> '<?php echo $individu['nik']?> - <?php echo ($individu['nama'])?>'
            <?php  }else{?> 'Ketik no nik di sini..'
            <?php  }?>,
            width: 260,
            noResultsText: 'Tidak ada no nik yang sesuai..',
            onSelect: function() {
                $('#' + 'main').submit();
            }
        });


        $('#showData').click(function() {
            $('tr.hide').show();
            $('#showData').hide();
            $('#hideData').show();
        });

        $('#hideData').click(function() {
            $('tr.hide').hide();
            $('#hideData').hide();
            $('#showData').show();
        });

        $('#hideData').hide();
    });

</script>
<style>
    table.form.detail th {
        padding: 5px;
        background: #fafafa;
        border-right: 1px solid #eee;
    }

    table.form.detail td {
        padding: 5px;
    }

    tr .hide {
        display: none;
    }

</style>
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;">
                <div id="contentpane">
                    <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                        <h3>Formulir Layanan : Surat Keterangan Rahasia</h3>
                        <div id="form-cari-pemohon">
                            <form action="" id="main" name="main" method="POST" class="formular">
                                <table class="form">
                                    <tr>
                                        <td width="200">NIK / Nama</td>
                                        <td>
                                            <div id="nik" name="nik"></div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        </br>
                        <div id="form-melengkapi-data-permohonan">
                            <form id="validasi" action="" method="POST" target="_blank">
                                <input type="hidden" name="nik" value="<?php echo $individu['id']?>" class="inputbox required">
                                <table class="form">
                                    <?php
						if($individu){
							?>
                                    <tr>
                                        <th width="200">Tempat Tanggal Lahir (Umur)</th>
                                        <td>
                                            <?php echo $individu['tempatlahir']?> <?php echo tgl_indo($individu['tanggallahir'])?> (<?php echo $individu['umur']?> Tahun)
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td><?php echo unpenetration($individu['alamat']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Pendidikan</th>
                                        <td><?php echo $individu['pendidikan']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Warganegara / Agama</th>
                                        <td><?php echo $individu['warganegara']?> / <?php echo $individu['agama']?></td>
                                    </tr>
                                    <tr>
                                        <th>Data Keluarga / KK </th>
                                        <td>
                                            <a class='uibutton special' id='showData'>Tampilkan</a>
                                            <a class='uibutton' id='hideData'>Sembunyikan</a>
                                        </td>
                                    </tr>

                                    <tr class="hide">
                                        <th colspan="1">Keluarga</th>
                                        <td colspan="1">
                                            <div style="margin-left:0px;">
                                                <table class="list">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th><input type="checkbox" class="checkall"></th>
                                                            <th align="left" width='70'>NIK</th>
                                                            <th align="left" width='100'>Nama</th>
                                                            <th align="left" width='30' align="center">JK</th>
                                                            <th width="70" align="left">Hubungan</th>
                                                            <th width="70" align="left">Umur</th>
                                                            <th width="70" align="left">Status Kawin</th>
                                                            <th width="100" align="left">Pendidikan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
												if($anggota!=NULL){
													$i=0;?>
                                                        <?php foreach($anggota AS $data){ $i++;?>
                                                        <tr>
                                                            <td align="center" width="2"><?php echo $i?></td>
                                                            <td align="center" width="5">
                                                                <input type="checkbox" name="id_cb[]" value="'<?php echo $data['nik']?>'">
                                                            </td>
                                                            <td><?php echo $data['nik']?></td>
                                                            <td><?php echo unpenetration($data['nama'])?></td>
                                                            <td><?php echo $data['sex']?></td>
                                                            <td><?php echo $data['hubungan']?></td>
                                                            <td><?php echo $data['umur']?></td>
                                                            <td><?php echo $data['status_kawin']?></td>
                                                            <td><?php echo $data['pendidikan']?></td>
                                                        </tr>
                                                        <?php }?>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Dokumen Kelengkapan / Syarat</th>
                                        <td>
                                            <a header="Dokumen" target="ajax-modal" rel="dokumen" href="<?php echo site_url("penduduk/dokumen_list/$individu[id]")?>" class="uibutton special">Daftar Dokumen</a><a target="_blank" href="<?php echo site_url("penduduk/dokumen/$individu[id]")?>" class="uibutton confirm">Manajemen Dokumen</a> )* Atas Nama <?php echo $individu['nama']?> [<?php echo $individu['nik']?>]
                                        </td>
                                    </tr>
                                    <?php
						}
						?>
                                    <tr>
                                        <th width="200">Nomor Surat</th>
                                        <td><input name="nomor" type="text" class="inputbox " size="12"></td>
                                    </tr>
                                    <tr>
                                        <th>Keperluan</th>
                                        <td>
                                            <textarea name="keperluan" class="" style="resize:none;height:80px;width:300px;" size="500"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tujuan</th>
                                        <td>
                                            <textarea name="tujuan" class="" style="resize:none;height:80px;width:300px;" size="500"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td>
                                            <textarea name="keterangan" class="" style="resize:none;height:80px;width:300px;" size="500"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Berlaku</th>
                                        <?php $skrg = date("d-m-Y")?>
                                        <td><input name="berlaku_dari" type="text" class="inputbox  datepicker" size="20" value="<?php echo $skrg;?>"> sampai <input name="berlaku_sampai" type="text" class="inputbox datepicker" size="20"></td>
                                    </tr>
                                    <tr>
                                        <th>Staf/ Jabatan Pemerintah Desa</th>
                                        <td><select name="pamong" class="inputbox required">
                                                <?php foreach($pamong AS $data){?>
                                                <option value="<?php echo $data['pamong_nama']?>"><?php echo $data['pamong_nama']?>(<?php echo $data['jabatan']?>)</option>
                                                <?php }?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sebagai</th>
                                        <td><select name="jabatan" class="inputbox required">
                                                <?php foreach($pamong AS $data){?>
                                                <option><?php echo $data['jabatan']?></option>
                                                <?php }?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                        </div>
                    </div>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <a href="<?php echo site_url('surat') ?>" class="uibutton icon prev">Kembali</a>
                        </div>
                        <div class="right">
                            <div class="uibutton-group">
                                <button class="uibutton" type="reset">Clear</button>
                                <button type="button" onclick="$('#'+'validasi').attr('action','<?php echo $form_action?>');$('#'+'validasi').submit();" class="uibutton special"><span class="ui-icon ui-icon-print">&nbsp;</span>Cetak</button>

                                <?php if (file_exists("surat/$url/$url.rtf")) { ?><button type="button" onclick="$('#'+'validasi').attr('action','<?php echo $form_action2?>');$('#'+'validasi').submit();" class="uibutton confirm"><span class="ui-icon ui-icon-document">&nbsp;</span>Export Doc</button><?php } ?>
                            </div>
                        </div>
                    </div>
                    </form>
            </td>
        </tr>
    </table>
</div>

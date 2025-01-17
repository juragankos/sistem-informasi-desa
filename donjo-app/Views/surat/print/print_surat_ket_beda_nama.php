<?php view('print/headjs.php');?>

<body>
    <div id="content" class="container_12 clearfix">
        <div id="content-main" class="grid_7">
            <link href="<?= asset('resources/css/surat.css') ?>" rel="stylesheet">
            <div>
                <table width="100%">
                    <tr> <img src="<?php echo base_url('assets/files/logo/' .  $desa['logo']) ?>" alt="" class="logo"></tr>
                    <div class="header">
                        <h4 class="kop">PEMERINTAH KABUPATEN <?php echo strtoupper(unpenetration($desa['nama_kabupaten']))?> </h4>
                        <h4 class="kop">KECAMATAN <?php echo strtoupper(unpenetration($desa['nama_kecamatan']))?> </h4>
                        <h4 class="kop">DESA <?php echo strtoupper(unpenetration($desa['nama_desa']))?></h4>
                        <h5 class="kop2"><?php echo (unpenetration($desa['alamat_kantor']))?> </h5>
                        <div style="text-align: center;">
                            <hr>
                        </div>
                    </div>
                    <div align="center"><u>
                            <h4 class="kop">SURAT KETERANGAN BEDA IDENTITAS</h4>
                        </u></div>
                    <div align="center">
                        <h4 class="kop3">Nomor : <?php echo $input['nomor']?></h4>
                    </div>
                </table>
                <div class="clear"></div>
                <table width="100%">
                    <td class="indentasi">Yang bertanda tangan dibawah ini <?php echo unpenetration($input['jabatan'])?> <?php echo unpenetration($desa['nama_desa'])?>, Kecamatan <?php echo unpenetration($desa['nama_kecamatan'])?>,
                        Kabupaten <?php echo unpenetration($desa['nama_kabupaten'])?>, Provinsi <?php echo unpenetration($desa['nama_propinsi'])?> menerangkan dengan sebenarnya bahwa: </td>
                    </tr>
                </table>
                <div id="isi3">
                    <table width="100%">
                        <tr></tr>
                        <tr>
                            <td colspan="3">I. Identitas dalam KK</td>
                        </tr>
                        <tr>
                            <td width="30%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?php echo unpenetration($data['nama'])?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tgl. Lahir </td>
                            <td>:</td>
                            <td><?php echo ($data['tempatlahir'])?>, <?php echo tgl_indo($data['tanggallahir'])?> </td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?php echo $data['sex']?></td>
                        </tr>
                        <tr>
                            <td>Alamat/ Tempat Tinggal</td>
                            <td>:</td>
                            <td>RW. <?php echo $data['rw']?>, RT. <?php echo $data['rt']?>, Dusun <?php echo unpenetration(ununderscore($data['dusun']))?>, Desa <?php echo unpenetration($desa['nama_desa'])?>, Kec. <?php echo unpenetration($desa['nama_kecamatan'])?>, Kab. <?php echo unpenetration($desa['nama_kabupaten'])?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?php echo $data['agama']?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?php echo $data['pekerjaan']?></td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <td colspan="3">II. Identitas dalam <?php echo $input['kartu']?></td>
                            <td width="3%"></td>
                            <td width="64%"></td>
                        </tr>
                        <tr>
                            <td width="30%">No Identitas</td>
                            <td width="3%">:</td>
                            <td width="64%"><?php echo $input['identitas']?></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><?php echo $input['nama']?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tanggal Lahir
                            <td>:</td>
                            <td><?php echo ($input['tempatlahir'])?> <?php echo tgl_indo(tgl_indo_in($input['tanggallahir']))?> </td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?php echo $input['sex']?></td>
                        </tr>
                        <tr>
                            <td>Alamat/ Tempat Tinggal</td>
                            <td>:</td>
                            <td><?php echo $input['alamat']?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?php echo $input['agama']?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?php echo $input['pekerjaan']?></td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td><?php echo $input['keterangan']?></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <td class="indentasi">Adalah benar-benar warga Desa <?php echo unpenetration($desa['nama_desa'])?> dan merupakan orang yang sama namun terdapat perbedaan <?php echo $input['perbedaan'] ?> seperti tersebut di atas. Adapun data yang benar dan dipakai seperti yang tercantum di Kartu Keluarga (KK). </td>
                        </tr>
                        <tr>
                            <td class="indentasi">Demikian surat keterangan ini dibuat dengan sesungguhnya agar dapat dipergunakan sebagaimana mestinya</td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                    </table>
                </div>
                <table width="100%">
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr>
                        <td width="23%"></td>
                        <td width="30%"></td>
                        <td align="center"><?php echo unpenetration($desa['nama_desa'])?>, <?php echo $tanggal_sekarang?></td>
                    </tr>
                    <tr>
                        <td width="23%"></td>
                        <td width="30%"></td>
                        <td align="center"><?php echo unpenetration($input['jabatan'])?> <?php echo unpenetration($desa['nama_desa'])?></td>
                    </tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr>
                        <td>
                        <td></td>
                        <td align="center">( <?php echo unpenetration($input['pamong'])?> )</td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="aside">
        </div>
    </div>
</body>

</html>

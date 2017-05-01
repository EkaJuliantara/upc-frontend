<?php
  ob_start();
  session_start();
  if ($_SESSION['hackfest_teams']['id']) {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title>Hackfest - Area Peserta</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mobile.css">

    <!-- Favicon
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <!--<link rel="icon" type="image/png" href="images/favicon.png">-->
  </head>
  <body>
    <section id="site-menu" class="site-menu putih">
        <div class="container">
            <div class="row">
                <div class="twelve columns">
                  <a href="index.html">
                      <img class="logo" src="logo1.png" alt="" />
                  </a>
                  <a class="logout" href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </section>

    <section id="bglogin" ng-app="hackFestApp" ng-init="idTeam=<?php echo $_SESSION['hackfest_teams']['id']; ?>" id="main">
      <div ng-controller="dataTeamCtrl" class="container">
        <div class="row">
          <div class="eight columns">
            <div class="box">
              <div class="box-body">

              <div>
                <h5>Data Tim</h5>
                <form ng-show="dataTeamLoaded" ng-submit="updateTeam()">
                  <table>
                    <tr>
                      <th>Nama Tim</th>
                      <td><input ng-model="dataTeam.name" type="text" name="name" required /></td>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <td><input ng-model="dataTeam.email" type="email" name="email" required /></td>
                    </tr>
                    <tr>
                      <th>No. HP</th>
                      <td><input ng-model="dataTeam.phone" type="text" name="phone" required /></td>
                    </tr>
                    <tr>
                      <th>Asal Sekolah</th>
                      <td><input ng-model="dataTeam.origin" type="text" name="origin" /></td>
                    </tr>
                    <tr>
                      <th>Kategori Lomba</th>
                      <td>{{ dataTeam.category.name }}</td>
                    </tr>
                    <tr>
                      <th>Vegetarian</th>
                      <td>
                        <input ng-model="dataTeam.vegetarian" type="radio" name="vegetarian" ng-value="1" /> Iya
                        <input ng-model="dataTeam.vegetarian" type="radio" name="vegetarian" ng-value="0" /> Tidak
                      </td>
                    </tr>
                  </table>
                  <button type="submit" class="btn">{{ button }}</button>
                </form>

                <p ng-hide="dataTeamLoaded">Sedang mengambil data dari server. Mohon tunggu sebentar ya...</p>
                </div>

                <br>

                <div>
                <h5>Detail</h5>
                <table ng-show="dataDetailsLoaded" class="table">
                  <thead>
                    <tr>
                      <th>
                        Proposal
                      </th>
                      <th>
                        Bukti Pembayaran
                      </th>
                      <th>
                        Status Proposal
                      </th>
                      <th>
                        Status Pembayaran
                      </th>
                      <th>

                      </th>
                    </tr>
                  </thead>
                  <tbody id="detail-list">

                  </tbody>
                </table>

                <p ng-hide="dataDetailsLoaded">Sedang mengambil data dari server. Mohon tunggu sebentar ya...</p>
                </div>

                <br>

                <div ng-controller="dataMembersCtrl">
                <h5>Data Anggota</h5>
                <table ng-show="dataMembersLoaded" class="table">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Surat Keterangan Mahasiswa Aktif</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="member-list">
                    <tr ng-repeat="data in dataMembers" class="member">
                      <td>
                        <input ng-show="hideMember == data.id" ng-model="data.name" type="text" required />
                        <span ng-hide="hideMember == data.id">{{ data.name }}</span>
                      </td>
                      <td>
                        <a href="http://api.ifest-uajy.com/storage/media/{{ data.media_name }}" target="_blank">Lihat</a>
                      </td>
                      <td>
                        <button ng-hide="hideMember == data.id" ng-click="hidingUpdateMember(data.id)" type="button" class="btn">Sunting</button> <button ng-show="hideMember == data.id" ng-click="updateMember(data)" type="button" class="btn">{{ btnUpdate }}</button> <button ng-click="destroyMember(data.id)" type="button" class="btn delete-member {{ data.id }}">Hapus</button>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <p ng-hide="dataMembersLoaded">Sedang mengambil data dari server. Mohon tunggu sebentar ya...</p>
                </div>

              </div>
            </div>
          </div>
          <div class="four columns">
            <div class="box">
              <div class="box-header">
                <h5>Pengumuman</h5>
              </div>
              <div class="box-body" style="text-align: left;">
                <p>Sebelum mengirimkan proposal, harus melunasi biaya pendaftaran terlebih dahulu yaitu Rp 100.000,-</p>
                <p>Untuk pembayaran dapat dilakukan langsung ke stand IFest di Lobby Fakultas Teknologi Industri, Kampus 3, Gedung Bonaventura, Jalan Babarsari 43 Yogyakarta atau melalui transfer ke <strong> Bank BCA dengan nomor rekening 0373749971 atas nama Grelly Lucia Yovellia Londo.</strong></p>
                <p>Ketentuan Proposal dapat didownload <a href="ketentuan\KETENTUAN_PROPOSAL.pdf">disini</a></p>
                <p>Kecepatan koneksi internet mempengaruhi cepatnya data ditampilkan. Apabila data belum tertampil, silakan muat ulang halaman.</p>
                <p>Kami menyarankan menggunakan browser Mozilla Firefox</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Document
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
 </body>
</html>

<script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="bower_components/angular/angular.min.js"></script>
<script type="text/javascript" src="bower_components/ng-file-upload-shim/ng-file-upload-shim.min.js"></script>
<script type="text/javascript" src="bower_components/ng-file-upload/ng-file-upload.min.js"></script>
<script type="text/javascript" src="js/hackfestApp.js"></script>

<?php
  }else{
    header("location: login.php");
  }
?>

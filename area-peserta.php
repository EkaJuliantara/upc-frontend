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

<script>
  function httpInterceptor() {
    return {
      request: function(config) {
        return config;
      },

      requestError: function(config) {
        return config;
      },

      response: function(res) {
        return res;
      },

      responseError: function(res) {
        return res;
      }
    }
  }

  var app = angular.module('hackFestApp', ['ngFileUpload'])
    .factory('httpInterceptor', httpInterceptor)
    .config(function($httpProvider) {
      $httpProvider.interceptors.push('httpInterceptor');
    });

  app.controller('dataTeamCtrl', function($scope, $http, $compile, $timeout, Upload) {

    $scope.dataTeam = {};
    $scope.errors = {};
    $scope.status = "";
    $scope.button = "Simpan";
    $scope.dataTeam = {};

    $scope.btnSave = "Simpan";
    $scope.infoProposal = "Pilih file untuk diunggah.";
    $scope.infoReceipt = "Pilih file untuk diunggah.";
    $scope.dataDetail = {};

    $scope.dataTeamLoaded = 0;
    $scope.dataMembersLoaded = 0;
    $scope.dataDetailsLoaded = 0;

    $scope.getTeam = function() {

      $http.get("http://api.ifest-uajy.com/v1/hackfest/"+$scope.idTeam).then(function (response) {

        $scope.dataTeamLoaded = 0;
        $scope.dataTeam = response.data.data;
        $scope.dataTeamLoaded = 1;
        if ($scope.dataTeam.status == 0) {
          $scope.status = "Tidak Aktif";
        }else{
          $scope.status = "Aktif";
        }

      });
    }

    $scope.uploadProposal = function(file, errFiles, id) {
      $scope.proposal = file;
      $scope.errProposal = errFiles && errFiles[0];
      $scope.infoProposal = $scope.proposal.name;

      if (id) {
        $('.proposal-info.'+id).text($scope.proposal.name);
      }else{
        $scope.infoReceipt= $scope.proposal.name;
      }
    }

    $scope.uploadReceipt = function(file, errFiles) {
      $scope.receipt = file;
      $scope.errReceipt = errFiles && errFiles[0];
      $scope.infoReceipt= $scope.receipt.name;
    }

    $scope.getDetail = function() {
      $http.get("http://api.ifest-uajy.com/v1/hackfest/"+$scope.idTeam).then(function (response) {

        $scope.dataDetailsLoaded = 0;
        $('.details').remove();
        $('.new-details').remove();

        $scope.dataTeam = response.data.data;

        if ($scope.dataTeam.receipt != null) {

          if ($scope.dataTeam.proposal != null) {
            $http.get("http://api.ifest-uajy.com/v1/media/"+response.data.data.proposal).then(function (response) {
              $scope.dataTeam.proposal_name = response.data.data.file_name;
            });
          }
          if ($scope.dataTeam.receipt != null) {
            $http.get("http://api.ifest-uajy.com/v1/media/"+response.data.data.receipt).then(function (response) {
              $scope.dataTeam.receipt_name = response.data.data.file_name;
            });
          }

          var row = angular.element('<tr class="details"><td><a ng-show="dataTeam.proposal != null" href="http://api.ifest-uajy.com/storage/media/{{ dataTeam.proposal_name }}" target="_blank">Lihat</a><button ng-show="dataTeam.proposal == null && dataTeam.confirmed == 1" type="file" ngf-select="uploadProposal($file, $invalidFiles, dataTeam.id)" ngf-max-size="10MB" class="btn">Unggah</button> <span ng-show="dataTeam.proposal == null && dataTeam.confirmed == 1" class="proposal-info {{ dataTeam.id }}">Pilih file untuk diunggah</span></td><td><a ng-show="dataTeam.receipt != null" href="http://api.ifest-uajy.com/storage/media/{{ dataTeam.receipt_name }}" target="_blank">Lihat</a></td><td><span ng-show="dataTeam.status == null && dataTeam.proposal != null">Menunggu verifikasi</span><span ng-show="dataTeam.status == 1 && dataTeam.proposal != null">Lolos</span><span ng-show="dataTeam.status == 0 && dataTeam.proposal != null">Tidak lolos</span></td><td><span ng-show="dataTeam.confirmed == null ">Menunggu verifikasi</span><span ng-show="dataTeam.confirmed == 1">Lolos</span><span ng-show="dataTeam.confirmed == 0">Tidak lolos</span></td><td><button ng-show="dataTeam.confirmed == 1 && dataTeam.proposal == null" ng-click="updateDetail(dataTeam.id)" type="button" class="btn update-detail {{ dataTeam.id }}">Simpan</button><button ng-show="dataTeam.confirmed != null && dataTeam.status != 1" ng-click="destroyDetail(dataTeam.id)" type="button" class="btn delete-detail {{ dataTeam.id }}">Hapus</button></td></tr>');

          $('#detail-list').append(row);

          $compile(row)($scope);

        }else{

          var row = angular.element('<tr class="new-details"><td></td><td><button ng-show="dataTeam.receipt == null" type="file" ngf-select="uploadReceipt($file, $invalidFiles)" accept="image/*" ngf-max-size="10MB" class="btn">Unggah</button> <span>{{ infoReceipt }}</span></td><td></td><td><button ng-click="addDetail()" type="button" class="btn">{{ btnSave }}</button></td></tr>');

          $('#detail-list').append(row);

          $compile(row)($scope);
        }

        $scope.dataDetailsLoaded = 1;

      });
    }

    $scope.addDetail = function() {
      if ($scope.receipt) {

        $scope.btnSave = "Menyimpan...";

        $scope.receipt.upload = Upload.upload({
            url: 'http://api.ifest-uajy.com/v1/media',
            data: { media: $scope.receipt }
        }).then(function (response) {

          $scope.infoReceipt = "Upload";
          $timeout(function() { $scope.infoReceipt = "Pilih file untuk diunggah." }, 1000);
          $scope.dataDetail['receipt'] = response.data.data.id;
          $scope.addDetailProcess();
          $scope.receipt = "";
        });
      }else{
          $scope.infoReceipt = "Unggah bukti pembayaran terlebih dahulu";
          $scope.btnSave = "Simpan";
      }
    }

    $scope.addDetailProcess = function() {
      $http({
        method  : 'PATCH',
        url     : 'http://api.ifest-uajy.com/v1/hackfest/'+$scope.idTeam+'/detail',
        data    : $.param($scope.dataDetail),
        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
       })
      .then(function(data) {
        $scope.btnSave = "Simpan";
        $scope.getDetail();
      });
    }

    $scope.updateDetail = function(id) {

      if ($scope.proposal) {

        $('.btn.update-detail.'+id).text('Menyimpan...');

        $scope.proposal.upload = Upload.upload({
            url: 'http://api.ifest-uajy.com/v1/media',
            data: { media: $scope.proposal }
        }).then(function (response) {

          $scope.dataDetail['proposal'] = response.data.data.id;

          $http({
            method  : 'PATCH',
            url     : 'http://api.ifest-uajy.com/v1/hackfest/'+$scope.idTeam+'/detail',
            data    : $.param($scope.dataDetail),
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
           })
          .then(function(data) {
            $('.btn.update-detail.'+id).text('Simpan');
            $('.proposal-info.'+id).text('Pilih file untuk diunggah');
            $scope.getDetail();
            $scope.proposal = "";
          });
        });
      }else{
        $('.btn.update-detail.'+id).text('Simpan');
        $('.proposal-info.'+id).text('Unggah proposal terlebih dahulu');
      }
    }

    $scope.destroyDetail = function(id) {

      $('.btn.delete-detail.'+id).text('Menghapus...');

      $scope.dataDetail['proposal'] = null;
      $scope.dataDetail['receipt'] = null;
      $scope.dataDetail['status'] = null;

      $http({
        method  : 'PATCH',
        url     : 'http://api.ifest-uajy.com/v1/hackfest/'+$scope.idTeam+'/detail',
        data    : $.param($scope.dataDetail),
        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
       })
      .then(function(data) {
        $scope.getDetail();
      });
    }

    $scope.getTeam();
    $scope.getDetail();

    $scope.updateTeam = function () {

      $scope.errors = {};
      $scope.button = "Menyimpan..."

      $http({
        method  : 'PATCH',
        url     : 'http://api.ifest-uajy.com/v1/hackfest/'+$scope.idTeam,
        data    : $.param($scope.dataTeam),
        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
       })
      .then(function(response) {
        switch (response.status) {
          case 400:
            $scope.errors = response.data.errors;
            $scope.button = "Simpan";
          break;
          case 500:
            $scope.errors.ise = "Mohon maaf terdapat kesalahan di bagian server.";
            $scope.button = "DAFTAR";
            break;
          default:
            $scope.button = "Tersimpan";
            $timeout(function() { $scope.button = "Simpan"; }, 1000);
        }
      });
    }

  });

  app.controller('dataMembersCtrl', function($scope, $http, $compile, $timeout, Upload) {

    $scope.dataMembers = {};
    $scope.newMembers = {};
    $scope.hideMember = false;
    $scope.errors = {};
    $scope.btnSave = "Simpan";
    $scope.btnUpdate = "Simpan";
    $scope.btnDelete = "Hapus";

    $scope.infoFullName = ""
    $scope.infoMedia = "Pilih file untuk diunggah.";


    $scope.uploadFiles = function(file, errFiles) {
        $scope.media = file;
        $scope.errMedia = errFiles && errFiles[0];
        $scope.infoMedia = $scope.media.name;
    }

    $scope.getMembers = function() {

      $scope.dataMembersLoaded = 0;
      $http.get("http://api.ifest-uajy.com/v1/hackfest/"+$scope.idTeam+'/members').then(function (response) {
        if (response.data.data) {
          $scope.dataMembers = response.data.data;
        }else{
          $scope.dataMembers = 0;
        }
        $scope.dataMembersLoaded = 1;

        angular.forEach($scope.dataMembers, function(value, key) {
          $http.get("http://api.ifest-uajy.com/v1/media/"+value.student_id_scan).then(function (response) {
            value.media_name = response.data.data.file_name;
          });
        });

        $('.new-member').remove();

        var count = $scope.dataMembers.length;

        if (count != 5) {
          var row = angular.element('<tr class="new-member"><td><input ng-model="newMembers.members[0][\'name\']" type="text" required="" /><br><span>{{ infoFullName }}</span></td><td><button type="file" ngf-select="uploadFiles($file, $invalidFiles)" accept="image/*" ngf-max-size="10MB" class="btn">Unggah</button><br><span>{{ infoMedia }}</span></td><td><button ng-click="addMembers()" type="button" class="btn">{{ btnSave }}</button></tr>');
          $('#member-list').append(row);
          $compile(row)($scope);
        }
      });
    }

    $scope.addMembers = function() {

      if ($scope.newMembers.members) {

        $scope.infoFullName = "";

        if ($scope.media) {

          $scope.btnSave = "Menyimpan...";

          $scope.media.upload = Upload.upload({
              url: 'http://api.ifest-uajy.com/v1/media',
              data: {media: $scope.media}
          });

          $scope.media.upload.then(function (response) {

            $scope.newMembers.members[0]["media_id"] = 0;
            $scope.newMembers.members[0]["student_id_scan"] = response.data.data.id;

            $http({
              method  : 'POST',
              url     : 'http://api.ifest-uajy.com/v1/hackfest/'+$scope.idTeam+'/members',
              data    : $.param($scope.newMembers),
              headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
             })
            .then(function(response) {
              switch (response.status) {
                case 400:
                  $scope.errors = response.data.errors;
                  $scope.btnSave = "Simpan";
                break;
                case 500:
                  $scope.errors.ise = "Mohon maaf terdapat kesalahan di bagian server.";
                  $scope.button = "DAFTAR";
                  break;
                default:
                  $scope.media = "";
                  $scope.newMembers = {};
                  $scope.btnSave = "Simpan";
                  $scope.getMembers();
                  $scope.infoMedia = "Pilih file untuk diunggah.";
              }
            });
          });

        }else{
          $scope.infoMedia = "Unggah kartu identitas!";
        }

      }else{
        $scope.infoFullName = "Isi nama lengkap!";
      }
    }

    $scope.updateMember = function(data) {

      $scope.btnUpdate = "Menyimpan...";

      $http({
        method  : 'PATCH',
        url     : 'http://api.ifest-uajy.com/v1/hackfest/'+$scope.idTeam+'/members/'+data.id,
        data    : $.param(data),
        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
       })
      .then(function(data) {
        $scope.hideMember = false;
        $scope.btnUpdate = "Simpan";
      });
    }

    $scope.hidingUpdateMember = function(id) {
      $scope.hideMember = id;
    }

    $scope.destroyMember = function(id) {

      $('.btn.delete-member.'+id).text('Menghapus...');

      $http.delete('http://api.ifest-uajy.com/v1/hackfest/'+$scope.idTeam+'/members/'+id).then(function (response) {
        $scope.getMembers();
      })
      .then(function(data) {
        $('.btn.delete-member.'+id).text('Terhapus');
        $timeout(function() { $('.btn.delete-member.'+id).text('Hapus'); }, 1000);
      });
    }

    $scope.getMembers();

  });

</script>

<?php
  }else{
    header("location: login.php");
  }
?>

var base_url = "http://127.0.0.1:8000/v1/hackfest/";
var media_url = "http://127.0.0.1:8000/v1/media/";

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

var registerApp = angular.module("registerApp", [])
  .factory('httpInterceptor', httpInterceptor)
  .config(function($httpProvider) {
    $httpProvider.interceptors.push('httpInterceptor');
  });

registerApp.controller("registerCtrl", function($scope, $http, $window) {

  $scope.formData = {};
  $scope.errors = {};

  $scope.button = "DAFTAR";

  $scope.registerSubmit = function () {

    $scope.errors = {};

    $scope.button = "MENDAFTAR...";

    $http({
      method  : 'POST',
      url     : base_url,
      data    : $.param($scope.formData),
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     })
    .then(function(response) {
      switch (response.status) {
        case 400:
          $scope.errors = response.data.errors;
          $scope.button = "DAFTAR";
        break;
        case 500:
          $scope.errors.ise = "Mohon maaf terdapat kesalahan di bagian server.";
          $scope.button = "DAFTAR";
          break;
        default:
          $window.location.href = 'pendaftaran-berhasil.html';
          $scope.button = "DAFTAR";
      }
    });
  }
});

var loginApp = angular.module("loginApp", [])
  .factory('httpInterceptor', httpInterceptor)
  .config(function($httpProvider) {
    $httpProvider.interceptors.push('httpInterceptor');
  });

loginApp.controller("loginCtrl", function($scope, $http, $window) {

  $scope.formData = {};
  $scope.errors = "";

  $scope.button = "MASUK";

  $scope.loginSubmit = function () {

    $scope.errors = "";

    $scope.button = "MASUK...";

    $http({
      method  : 'POST',
      url     : base_url+'login',
      data    : $.param($scope.formData),
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     })
    .then(function(response) {
      switch (response.status) {
        case 404:
          $scope.errors = response.data.errors;
          $scope.button = "MASUK";
        break;
        case 500:
          $scope.errors.ise = "Mohon maaf terdapat kesalahan di bagian server.";
          $scope.button = "MASUK";
          break;
        default:
          $scope.button = "MASUK...";

          $http({
            method  : 'POST',
            url     : 'proses-login.php',
            data    : $.param({ id: response.data.data.id }),
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
          }).then(function(data) {
            $window.location.href = 'area-peserta.php';
          });
      }
    });
  }
});

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

    $http.get(base_url+$scope.idTeam).then(function (response) {

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
    $http.get(base_url+$scope.idTeam).then(function (response) {

      $scope.dataDetailsLoaded = 0;
      $('.details').remove();
      $('.new-details').remove();

      $scope.dataTeam = response.data.data;

      if ($scope.dataTeam.receipt != null) {

        if ($scope.dataTeam.proposal != null) {
          $http.get(media_url+response.data.data.proposal).then(function (response) {
            $scope.dataTeam.proposal_name = response.data.data.file_name;
          });
        }
        if ($scope.dataTeam.receipt != null) {
          $http.get(media_url+response.data.data.receipt).then(function (response) {
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
      url     : base_url+$scope.idTeam+'/detail',
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
          url     : base_url+$scope.idTeam+'/detail',
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
      url     : base_url+$scope.idTeam+'/detail',
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
      url     : base_url+$scope.idTeam,
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
    $http.get(base_url+$scope.idTeam+'/members').then(function (response) {
      if (response.data.data) {
        $scope.dataMembers = response.data.data;
      }else{
        $scope.dataMembers = 0;
      }
      $scope.dataMembersLoaded = 1;

      angular.forEach($scope.dataMembers, function(value, key) {
        $http.get(media_url+value.student_id_scan).then(function (response) {
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
            url     : base_url+$scope.idTeam+'/members',
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
      url     : base_url+$scope.idTeam+'/members/'+data.id,
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

    $http.delete(base_url+$scope.idTeam+'/members/'+id).then(function (response) {
      $scope.getMembers();
    })
    .then(function(data) {
      $('.btn.delete-member.'+id).text('Terhapus');
      $timeout(function() { $('.btn.delete-member.'+id).text('Hapus'); }, 1000);
    });
  }

  $scope.getMembers();

});
var assert = require('assert');
var chai = require('chai');     //Biblioteca para Mocha
var expect = chai.expect;
chai.use(require('chai-fs'));
var request = require('supertest'); 

var url = "http://bibliometricanalyzer-jcristobal.rhcloud.com/"; //URL de la web

var apikey = "c0dee35412af407a9c07b4fabc7bc447";


describe('Test básicos', function() {


  describe('Pruebas de conexión', function () {

    it('Web (OpenShift) disponible', function (done) {
      request(url).get('/').expect(200).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });


  })

  describe('Pruebas sobre consultas', function () {

    it('Valid ApiKey', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3E+2015)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Agricultural and Biological Sciences" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(AGRI)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Arts and Humanities" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(ARTS)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Biochemistry, Genetics and Molecular Biology" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(BIOC)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Business, Management and Accounting" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(BUSI)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Chemical Engineering" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(CENG)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Chemistry" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(CHEM)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Computer Science" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(COMP)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });
    it('Topic "Decision Sciences" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(DECI)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Dentistry" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(DENT)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Earth and Planetary Sciences" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(EART)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Economics, Econometrics and Finance" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(ECON)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Energy" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(ENER)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Engineering" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(ENGI)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Environmental Science" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(ENVI)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Health Professions" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(HEAL)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Immunology and Microbiology" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(INMU)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Materials Science" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(MATE)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Mathematics" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(MATH)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Medicine" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(MEDI)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Neuroscience" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(NEUR)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Nursing" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(NURS)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Pharmacology, Toxicology and Pharmaceutics" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(PHAR)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Physics and Astronomy" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(PHIS)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

    it('Topic "Psychology" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(PSYC)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });    

   it('Topic "Social Sciences" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(SOCI)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });    

   it('Topic "Veterinary" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(VETE)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });

   it('Topic "Multidisciplinary" available', function (done) {
      request("http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR+%3C+2015)%20and%20(PUBYEAR+%3E+2013)%20and%20SUBJAREA(MULT)&apiKey="+apikey+"&httpAccept=application/json").get('/').expect(406).end(function(err, res){
      if (err)
        return done(err)
        done();
      });
    });




  })



});

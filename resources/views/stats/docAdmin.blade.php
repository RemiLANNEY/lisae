@extends("template")

@section("titre")
	Etat document administratif
@endsection

@section("content")
<table id="statsDocAdmin" class="display">
  <thead>
    <tr>
      <td>Nom</td>
      <td>Prénom</td>
      <td>Date de naissance</td>
      <td>Carte d'identité</td>
      <td>Ass. Maladie</td>
      <td>Justif domicile</td>
      <td>Attestation Resp. Civile</td>
      <td>Attestation suivi de F.</td>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <td>Nom</td>
      <td>Prénom</td>
      <td>Date de naissance</td>
      <td>Carte d'identité</td>
      <td>Ass. Maladie</td>
      <td>Justif domicile</td>
      <td>Attestation Resp. Civile</td>
      <td>Attestation suivi de F.</td>
    </tr>
  </tfoot>
  <tbody>
    @foreach($etatsDocAdmin as $candidatAdmin)
    <tr>
      <td>{{ $candidatAdmin['Nom'] }}</td>
      <td>{{ $candidatAdmin['Prenom'] }}</td>
      <td>{{ $candidatAdmin['date_de_naissance'] }}</td>
      <td><center>{{ $candidatAdmin['cni'] }}</center></td>
      <td><center>{{ $candidatAdmin['AssMaladie'] }}</center></td>
      <td><center>{{ $candidatAdmin['JustifDomicile'] }}</center></td>
      <td><center>{{ $candidatAdmin['AssuranceRespCivile'] }}</center></td>
      <td><center>{{ $candidatAdmin['AttestaionSuiviDeFormation'] }}</center></td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection

@section('script')
<script>
  jQuery(document).ready(function(){
    jQuery('#statsDocAdmin').DataTable({
      "paging":   false,
      "info":     false
     });
  });
</script>
@endsection
@extends('frontend.home.index')

@section('content')
<section class="sec">
  <div class="wrap">
    <div class="head">
      <div>
        <h1 style="font-size:42px">Educational Resources</h1>
        <p>Short, careful articles on the compounds in our catalogue, written to explain rather than to sell.</p>
      </div>
    </div>
    <div class="g3">
      <div class="card pc" style="padding:20px">
        <h3>Understanding Retatrutide</h3>
        <p style="font-size:13px;color:var(--mut);margin:10px 0 16px">An investigational triple-receptor agonist (GIP, GLP-1, Glucagon) and what early research shows.</p>
        <span style="font-size:11px;font-weight:600;color:var(--green)">Read Note →</span>
      </div>
      <div class="card pc" style="padding:20px">
        <h3>The Science of GHK-Cu</h3>
        <p style="font-size:13px;color:var(--mut);margin:10px 0 16px">A naturally occurring copper peptide and its investigated role in tissue regeneration.</p>
        <span style="font-size:11px;font-weight:600;color:var(--green)">Read Note →</span>
      </div>
    </div>
  </div>
</section>
@endsection
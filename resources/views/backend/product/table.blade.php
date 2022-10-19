{{-- <div style="overflow: auto;width: 100%">  --}}
  @if (isset($products) && count($products) > 0)
    <table id="load" style=" white-space:nowrap;" class="table table-striped projects">
    <thead>
      <tr>
        <th style="width: 1%">#</th>
        <th style="width: 10%">Name</th>
        <th>Phone</th>
        <th>Select1</th>
        <th>Link</th>
        <th>Reference Type</th>
        <th>Reference ID</th>
        <th>Transaction ID</th>
        <th>Current Group ID</th>
        <th>Source</th>
        <th>Campaign </th>
        <th style="width: 5%">str_source_group</th>
        <th style="width: 5%">str_secondary_source</th>
        <th>is Digital</th>
        <th>F88 Note</th>
        <th>Status F88</th>
        <th>Loan Money Org</th>
        <th>Last Comment</th>
      </tr>
    </thead>
    <tbody>
        @php $i = 0;
        @endphp
        @foreach($products as $product) 
        @php 
        $i += 1;
        @endphp
      <tr>
        <td>{{$i}}</td>
        <td>
          <a>{{$product->name}}</a>
        </td>
        <td>
            <a>{{$product->phone}}</a>
        </td>
        <td>
            <a>{{$product->select1}}</a>
        </td>
        <td class="project_progress">
            <a>{{$product->link}}</a>
        </td>
        <td>
            <a>{{$product->reference_type}}</a>
        </td>
        <td>
            <a>{{$product->reference_id}}</a>
        </td>
        <td>
          <a>{{$product->transaction_id}}</a>
      </td>
        <td>
            <a>{{$product->current_group_id}}</a>
        </td>
        <td>
            <a>{{$product->source}}</a>
        </td>
        <td>
            <a>{{$product->campaign}}</a>
        </td>
        <td>
            <a>{{$product->str_source_group}}</a>
        </td>
        <td>
            <a>{{$product->str_secondary_source}}</a>
        </td>
        <td>
            <a>{{$product->isdigital}}</a>
        </td>
        @if($product->f88_note == "")
          <td style="text-align: center" colspan="4">Chưa trả kết quả!</td>
       @else 
       <td><a>{{$product->f88_note}}</a></td>
       <td><a>{{$product->status_f88}}</a></td>
       <td><a>{{$product->loan_money_org}}</a></td>
          @foreach($product->comments as $c)
            @if($loop->last)
              <td>{{ $c->comment }}</td>
            @endif
          @endforeach
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <table id="load" style=" white-space:nowrap;" class="table table-striped projects">
    <p>Không có dữ liệu!</p>
  </table>
  @endif
  {!! $products->links() !!}
  {{-- {!! $products->render() !!} --}}

  {{-- </div> --}}
 
  <!-- end project list -->
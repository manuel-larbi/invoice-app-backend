<div class="header">
    <div class="nav">
        <p style="font-family: monospace">INVOICE</p>
        <div class="inv-id">
            <div>
                <p style="font-family: monospace; margin-top: 1.8rem;">
                    {{ $id }}
                </p>
            </div>
            <p class="dot dot-1"></p>
        </div>
    </div>
    <div>
        <p class="inv-title" style="font-family: monospace; text-transform: capitalize">{{$description}}</p>
        <div class="bill">
            <p class="bill-to" style="font-family: monospace">BILLING TO:</p>
            <p>{{ $name }}</p>
            <p>{{ $clientStreet }}</p>
            <p>{{ $clientCity }}</p>
        </div>
    </div>
    <!-- <div> -->
    <table>
        <thead>
            <th>PRODUCT</th>
            <th>PRICE</th>
            <th>QTY</th>
            <th>TOTAL</th>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr class="border-b border-black">
                <td class="td">{{ $item->name}}</td>
                <td class="td">${{ number_format(($item->price),2,'.','') }}</td>
                <td class="td">{{ $item->quantity}}</td>
                <td class="td">${{ number_format(($item->total),2,'.','')}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- </div> -->
    <div class="total">Grand Total: ${{ $total }}</div>
</div>
<style>
    /* .main {
        padding: 2rem;
    } */
    .header {
        font-family: monospace;
        border: solid;
        position: relative;
        padding-top: 1rem;
        padding-bottom: 5rem;
        height: 100vh;
        width: 100%;
    }

    .nav > p:first-child {
        color: white;
        font-size: 2rem;
        width: 200px;
        padding: 1rem 3rem;
        padding-right: 1rem;
        background-color: black;
        font-weight: 600;
        letter-spacing: 0.5rem;
        font-family: monospace;
    }

    .inv-id {
        top: 2.5rem;
        right: 3rem;
        position: absolute;
        display: flex;
        align-items: center;
    }

    .inv-id > div p:first-child {
        font-weight: bold;
        letter-spacing: 0.2rem;
    }
    .dot {
        width: 1.5rem;
        height: 1.5rem;
        background-color: black;
    }

    .dot-1 {
        position: absolute;
        right: -3rem;
        top: .5rem;
    }
    .inv-title {
        padding: 0.3rem 0;
        padding-left: 3rem;
        font-weight: 600;
        width: 20%;
        border-bottom: 1px solid;
    }

    .bill {
        padding-left: 3rem;
    }
    .bill-to {
        font-family: monospace;
        font-weight: 600;
    }

    table {
        width: 100%;
        margin-top: 1rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    th,
    td {
        padding: 15px;
        color: #fff;
    }
    td {
        text-align: center;
        color: black;
        border-bottom: 1px solid black;
    }
    th {
        text-align: center;
        font-size: large;
    }
    thead th {
        background-color: #000000;
    }

    tbody td {
        position: relative;
    }

    .total {
        float: right;
        margin-top: 3rem;
        margin-right: 3.5rem;
    }

    .terms {
        margin-top: 3rem;
        display: flex;
        align-items: center;
    }

    .dot-2 {
        margin: 0;
        margin-right: 1rem;
    }

</style>

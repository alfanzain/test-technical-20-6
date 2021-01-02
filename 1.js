let hitungUangKembalian = (param1, param2) => {
    let totalKembalian = param1 - param2
    let kembalian = {}
    let pecahanUang = [
        100000,
        50000,
        20000,
        10000,
        5000,
        2000,
        1000,
        500,
        200,
        100
    ]

    for (let i = 0; totalKembalian > 0 && i < pecahanUang.length; i++) {
        let nilaiUang = pecahanUang[i]

        if (nilaiUang <= totalKembalian) {
            kembalian[nilaiUang] = Math.floor(totalKembalian / nilaiUang)

            totalKembalian -= nilaiUang * kembalian[nilaiUang]
        }
    }

    console.log('Uang dibayar : ' + param1)
    console.log('Total bayar : ' + param2)
    console.log('================================================')
    console.log('Uang pecahan Rp xxx sebanyak ')
    console.log('================================================')
    console.log('Kembalian : ' + totalKembalian)
    console.log('Terbilang : ')
}
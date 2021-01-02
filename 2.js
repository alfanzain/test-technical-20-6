const cariNilaiTeratas = array => {
    array = array.filter(number => number % 2)

    let highest
    let ordinal = ['pertama', 'kedua', 'ketiga']

    for (let i = 0; i < 3; i++) {
        highest = array[0]
        let removedIndex = null

        for (let j = 0; j < array.length; j++) {
            let number = array[j]

            if (number > highest) {
                highest = number
                removedIndex = j
            }
        }

        console.log(`Nilai tertinggi ${ordinal[i]}: ${highest}`)

        array.splice(removedIndex, 1)
    }
}
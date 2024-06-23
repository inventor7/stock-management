<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}} Invoice</title>
    @vite('resources/css/app.css')
</head>


<body class=" mx-8 ">

    <img class=" fixed -right-64 top-[16rem] h-[30rem]  -z-20 opacity-10 object-cover   "
        src ="{{ asset('assets/MondialLogo.png') }}" />

    <div class="container  space-y-12 ">
        <header class="mt-8 space-y-12 ">
            <div class="flex flex-row justify-between items-start w-full  h-20  ">
                <div class="flex flex-row justify-start items-center gap-2  w-full text-gray-500 ">
                    <img class=" object-cover h-16  " src ="{{ asset('assets/MondialLogo.png') }}" />
                    <div class="flex flex-col justify-start items-start w-fit gap-1 ">
                        <h1 class="font-bold font-serif text-lg text-black ">Sarl Mondial Prestige</h1>
                        <p class="font-serif
                    text-xs"> Fabrication et Importation de Mobilier</p>

                    </div>
                </div>
                <div class="flex flex-col justify-end items-end w-full gap-2 ">
                    <p class=" text-sm"> Date d'expo: {{ now()->format('d/m/Y') }}</p>


                </div>
            </div>
            <h1 class="text-3xl text-center font-bold whitespace-nowrap  "> Bon {{ $title }} </h1>

        </header>
        <main>

            @yield('content')
        </main>
        <footer>
        </footer>
    </div>
</body>

</html>

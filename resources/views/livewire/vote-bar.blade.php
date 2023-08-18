<div>
    @if (!$voteType)
        <div class="mb-3 text-gray-600 tracking-wide flex gap-2 items-center justify-center">
            <x-icons.information-circle class="w-6 h-6" />
            {{ __('Click the bar to cast your vote!') }}
        </div>
    @endif

    <div class="flex shadow-lg font-bold rounded-full overflow-hidden p-1.5 lg:p-3 bg-gray-200 max-w-[1100px] mx-auto">
        {{-- Left (green) bar --}}
        <div
            @class([
                'py-1.5 lg:py-3 px-6 flex-grow text-left md:min-w-[15%] min-w-[20%] rounded-l-full bg-gradient-to-r from-agree to-agree-light text-white hover:opacity-100 transition-opacity duration-300',
                'cursor-not-allowed opacity-100' => $hasVoted,
                'hover:bg-green-600 cursor-pointer opacity-70' => ! $hasVoted,
            ])
            style="width: {{ $rfc->percentage_yes }}%;"

            @if(! $hasVoted)
                wire:click="vote('{{ App\Models\VoteType::YES }}')"
            @endif
        >
            {{ $rfc->percentage_yes }}%
        </div>

        {{-- Right (red) bar --}}
        <div
            @class([
                'py-1.5 lg:py-3 px-6 flex-grow text-right md:min-w-[15%]min-w-[20%] rounded-r-full bg-gradient-to-r from-disagree to-disagree-light text-white hover:opacity-100 transition-opacity duration-300',
                'cursor-not-allowed opacity-100' => $hasVoted,
                'hover:bg-red-600 cursor-pointer opacity-70' => ! $hasVoted,
            ])
            style="width: {{ $rfc->percentage_no }}%;"

            @if(! $hasVoted)
                wire:click="vote('{{ \App\Models\VoteType::NO }}')"
            @endif
        >
            {{ $rfc->percentage_no }}%
        </div>
    </div>

    @if($voteType)
        <div class="flex justify-center mt-6 font-bold items-baseline gap-1">
            {{ $userArgument ? "You've voted" : "You're voting" }}&nbsp;<span @class([
                'p-1 px-3 rounded-full text-white shadow-md',
                'bg-green-500' => $voteType === App\Models\VoteType::YES,
                'bg-red-500' => $voteType === App\Models\VoteType::NO,
            ])>{{ $voteType->value }}</span>@if(!$userArgument)
                Next, give your arguments:
            @else
                !
            @endif
        </div>
    @endif

    @if(!$userArgument && $voteType)
        <div class="flex {{ $voteType->getJustify() }} mt-6">
            <div @class([
                'flex-1 p-4 flex gap-4 items-end bg-white border-gray-200 shadow-md p-4 gap-4 items-center',
                $voteType->getJustify(),
                'border-l-green-400 border-l-8 md:mr-8' => $voteType === App\Models\VoteType::YES,
                'border-r-red-400 border-r-8 md:ml-8' => $voteType !== App\Models\VoteType::YES,
            ])>
                <div class="w-full">
                    <small>Your argument:</small>

                    <div class="grid gap-2">
                        <x-markdown-editor
                            wire:model="body"
                            @class([
                                'rounded w-full border',
                                'border-green-200 active:border-green-200' => $voteType->getColor() === 'green',
                                'border-red-200 active:border-red-200' => $voteType->getColor() === 'red',
                           ])
                        />

                        @error('body')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <button
                        type="submit"
                        @class([
                            'font-bold py-2 px-4 text-white text-center rounded-full',
                            'cursor-not-allowed' => empty($this->body),
                            'cursor-pointer hover:bg-green-600' => ! empty($this->body) && $voteType->getColor() === 'green',
                            'cursor-pointer hover:bg-red-600' => ! empty($this->body) && $voteType->getColor() === 'red',
                            'bg-green-400' => $voteType->getColor() === 'green',
                            'bg-red-400' => $voteType->getColor() === 'red',

                        ])
                        wire:click="storeArgument"
                    >
                        Submit
                    </button>

                    <button
                        class="bg-gray-100 hover:bg-gray-200 py-2 px-4 text-center rounded-full"
                        wire:click="cancel"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

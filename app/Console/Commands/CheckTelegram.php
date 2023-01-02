<?php

namespace App\Console\Commands;

use App\Models\TelegramInbound;
use Classes\TelegramHelper;
use Exception;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class CheckTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:telegram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'checking telegram updates and respond';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $offset = TelegramInbound::max('update_id');

        if ($offset == null)
            $offset = 0;

        $updates = Telegram::getUpdates([
            'offset' => $offset,
            'limit' => 100,
            'timeout' => 0]);

        //Log::info($updates);
        foreach ($updates as $update) {

            if (array_has($update, 'message.text')) {

                $update_id = $update['update_id'];
                $message_id = $update['message']['message_id'];
                $user_id = $update['message']['from']['id'];

                $chat_id = $update['message']['chat']['id'];
                $command = $update['message']['text'];

                if (array_has($update['message'], 'from.username'))
                    $username = $update['message']['from']['username'];
                else $username = 'unknown';

                if (array_has($update['message'], 'from.first_name'))
                    $firstname = $update['message']['from']['first_name'];
                else $firstname = 'unknown';

                if (array_has($update['message'], 'from.last_name'))
                    $lastname = $update['message']['from']['last_name'];
                else $lastname = 'unknown';

                $telegramHelper = new TelegramHelper($command);

                $response_text = $telegramHelper->getMessage();


                $msg = TelegramInbound::where('update_id', $update_id)->first();

                $success = false;
                if ($msg == null) {
                    try {

                        $response = Telegram::sendMessage([
                            'chat_id' => $chat_id,
                            'text' => $response_text['msg'],
                            'reply_markup' => json_encode($response_text['keyboard'])
                        ]);
                        $messageId = $response->getMessageId();
                        $success = true;
                    } catch (Exception $ex) {
                        $success = false;
                    } finally {

                        TelegramInbound::create([
                            'update_id' => $update_id,
                            'message_id' => $message_id,
                            'user_id' => $user_id,
                            'chat_id' => $chat_id,
                            'user_name' => $username,
                            'first_name' => $firstname,
                            'last_name' => $lastname,
                            'response_text' => $response_text['msg'],
                            'response_date' => \Carbon\Carbon::now(),
                            'response_success' => $success,
                            'text' => $command
                        ]);

                    }
                }
            }
        }
    }
}
import useWebSocket from 'react-use-websocket'

const WS_STOCK_QUOTES_URL = 'wss://trade.termplat.com:8800/?password=1234'

type Message = {
  id: string
  value: number
}

type OnMessage = (data: Message) => void

const useStockQuotesWS = (onMessage: OnMessage, shouldConnect = true): void => {
  useWebSocket<Message>(
    WS_STOCK_QUOTES_URL,
    {
      share: true,
      onMessage: (event) => {
        const data = JSON.parse(event.data as string) as Message

        onMessage(data)
      },
    },
    shouldConnect
  )
}

export default useStockQuotesWS

import React, { useMemo, useRef } from 'react'
import { Grid } from '@/Common/Table'
import { useTypedSelector } from '@/app/store/redux/store'
import { useLazyStockQuotesGetStatisticsQuery } from '@/app/store/redux/services/injects/stockQuotes'
import useElementWatcher from '@/hooks/useElementWatcher'

const headers = [
  {
    id: 'average',
    value: 'Середнє арифметичне',
  },
  {
    id: 'standardDeviation',
    value: 'Стандартне відхилення',
  },
  {
    id: 'mode',
    value: 'Мода',
  },
  {
    id: 'min',
    value: 'Мінімальне значення',
  },
  {
    id: 'max',
    value: 'Максимальне значення',
  },
  {
    id: 'startDate',
    value: 'Дата/час запуску розрахунків',
  },
  {
    id: 'calculationTime',
    value: 'Час витрачений на розрахунки',
  },
]

const StockQuotesStatisticGrid: React.FC = (): JSX.Element => {
  const ref = useRef(null)
  const {
    stockQuotesStatistics,
    lessCreateAt,
    stockQuotesStatisticsCurrentMeta: currentMeta,
  } = useTypedSelector((state) => state.stockQuotes)
  const [getStatisticsTrigger] = useLazyStockQuotesGetStatisticsQuery()

  useElementWatcher(ref, () => {
    const { currentPage = 1, totalPages = 1 } = currentMeta || {}

    if (currentPage >= totalPages) {
      return
    }

    void getStatisticsTrigger({ page: currentPage + 1, lessCreateAt })
  })

  const rows = useMemo(() => {
    return (
      stockQuotesStatistics.map((statistic) => ({
        id: statistic.id,
        columns: [
          {
            id: 'average',
            value: statistic.average,
          },
          {
            id: 'standardDeviation',
            value: statistic.standardDeviation,
          },
          {
            id: 'mode',
            value: statistic.mode,
          },
          {
            id: 'min',
            value: statistic.min,
          },
          {
            id: 'max',
            value: statistic.max,
          },
          {
            id: 'startDate',
            value: statistic.startDate,
          },
          {
            id: 'calculationTime',
            value: (new Date(statistic.endDate).getTime() - new Date(statistic.startDate).getTime()) / 1000,
          },
        ],
      })) || []
    )
  }, [stockQuotesStatistics])

  return (
    <div>
      <Grid headers={headers} rows={rows} />
      <div ref={ref} />
    </div>
  )
}

export default StockQuotesStatisticGrid

import React, { useMemo } from 'react'
import { Grid } from '@/Common/Table'
import { useGetStatisticsQuery } from '@/app/store/redux/services/injects/stockQuotes'

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
  const { data } = useGetStatisticsQuery()

  const rows = useMemo(() => {
    return (
      data?.data.map((statistic) => ({
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
            value: (statistic.endDate - statistic.startDate) / 1000,
          },
        ],
      })) || []
    )
  }, [data])

  return <Grid headers={headers} rows={rows} />
}

export default StockQuotesStatisticGrid

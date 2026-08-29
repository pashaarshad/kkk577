import dayjs from 'dayjs'

export function formatDate(date, format='YYYY-MM-DD HH:mm:s') {
  return dayjs.unix(Number(date)).format(format)
}
